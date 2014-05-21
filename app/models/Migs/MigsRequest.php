<?php namespace Migs;

class MigsRequest {

    /**
     * @var MigsGenerator
     */
    protected $generator;

    /**
     * @var MigsAccount
     */
    protected $account;

    /**
     * @param MigsGenerator $generator
     * @param MigsAccount $account
     */
    public function __construct(MigsGenerator $generator, MigsAccount $account)
    {
        $this->generator = $generator;
        $this->account = $account;
    }


    /**
     * @param MigsPayment $payment
     * @param string $returnUrl
     * @return string
     */
    public function simplePaymentUrl(MigsPayment $payment, $returnUrl = '')
    {
        $queryData = $this->generator->getQueryData($this->account, $payment, $returnUrl);

        return $this->getUrl($queryData);
    }

    /**
     * @param array $params
     * @return string
     */
    public function getUrl(array $params = array())
    {
        return 'https://migs.mastercard.com.au/vpcpay?'.http_build_query($params);
    }
}