<?php namespace Migs;

use Illuminate\Routing\Redirector;

class MigsManager {

    /**
     * @var MigsAccount
     */
    protected $account;

    /**
     * @var MigsSecretHasher
     */
    protected $secretHasher;

    /**
     * @param MigsAccount $account
     * @param MigsPayment $payments
     * @param MigsTransaction $transaction
     * @param MigsSecretHasher $secretHasher
     */
    public function __construct(MigsAccount $account, MigsPayment $payments, MigsTransaction $transaction, MigsSecretHasher $secretHasher)
    {
        $this->account = $account;
        $this->payments = $payments;
        $this->secretHasher = $secretHasher;
        $this->transaction = $transaction;
    }

    /**
     * Make payment request
     * @param MigsPayment $payment
     * @param string $returnUrl
     * @return Redirector
     */
    public function makePaymentRequest(MigsPayment $payment, $returnUrl = '')
    {
        $params = $this->getRequestInputs($payment, $returnUrl);

        return Redirect::to($this->getUrl($params));
    }

    /**
     * Save payment response to the database
     *
     * @param array $inputs
     * @throws MigsTransactionException
     * @throws MigsSecretException
     * @return MigsTransaction
     */
    public function savePaymentResponse(array $inputs = array())
    {
        // Make sure the secret is correct
        if($this->getSecretHash($inputs) !== $inputs['vpc_SecureHash']) {

            throw new MigsSecretException("Secret is not matchable");
        }

        // If response not successful
        if(!( $inputs['vpc_TxnResponseCode'] === '0' && $inputs['vpc_Message'] === 'Approved')) {

            throw new MigsTransactionException("Something went wrong while trying to ");
        }

        // Everything is fine.. Now create a new transaction with the given inputs
        $payment = $this->payments->byUniqueIdentifier($inputs['vpc_MerchTxnRef'])->first();

        // Create new transaction
        return $payment->transaction()->create($inputs);
    }

    /**
     * @param MigsPayment $payment
     * @param string $returnUrl
     * @return array
     */
    public function getRequestInputs(MigsPayment $payment, $returnUrl = '')
    {
        $orderUniqueId = $payment->order->unique_identifier;
        $amount = $payment->amount;
        $currency = $payment->currency;

        $orderInfo = 'Paying for order #'.$orderUniqueId;

        $data = array(
            'vpc_AccessCode' => $this->account->access_code,
            'vpc_Merchant' => $this->account->merchant_id,

            'vpc_Amount' => ($amount * 100), // Multiplying by 100 to convert to the smallest unit
            'vpc_Currency' => $currency,
            'vpc_OrderInfo' => $orderInfo,

            'vpc_MerchTxnRef' => $orderUniqueId,

            'vpc_Command' => 'pay',
            'vpc_Locale' => 'en',
            'vpc_Version' => 1,

//            'vpc_SecureHashType' => 'SHA256'
        );

        if($returnUrl) $data['vpc_ReturnURL'] = $returnUrl;

        $data['vpc_SecureHash'] = $this->getSecretHash($data);

        return $data;
    }

    /**
     * @param array $params
     * @return string
     */
    public function getUrl(array $params = array())
    {
        return 'https://migs.mastercard.com.au/vpcpay?'.http_build_query($params);
    }


    /**
     * @param $data
     * @return string
     */
    public function getSecretHash($data)
    {
        return $this->secretHasher->md5($this->account, $data);
    }
}