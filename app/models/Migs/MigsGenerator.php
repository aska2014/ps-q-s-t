<?php namespace Migs;

class MigsGenerator {

    /**
     * Get settings
     *
     * @todo This method should take the order
     * @param MigsAccount $account
     * @param string $returnUrl
     * @return array
     */
    public function getQueryData(MigsAccount $account, $returnUrl = '')
    {
        $amount = 100.50;
        $currency = 'EGP';
        $orderInfo = 'ORDER34524';

        $data = array(
            'vpc_AccessCode' => $account->access_code,
            'vpc_Merchant' => $account->merchant_id,

            'vpc_Amount' => ($amount * 100), // Multiplying by 100 to convert to the smallest unit
            'vpc_Currency' => $currency,
            'vpc_OrderInfo' => $orderInfo,

            'vpc_MerchTxnRef' => $this->generateMerchTxnRef(), // See functions.php file

            'vpc_Command' => 'pay',
            'vpc_Locale' => 'ar',
            'vpc_Version' => 1,

            'vpc_SecureHashType' => 'SHA256'
        );

        $data['vpc_SecureHash'] = $this->generateSecureSecretHash($account->secret, $data);

        if($returnUrl) $data['vpc_ReturnURL'] = $returnUrl;

        return $data;
    }

    /**
     * Generate secure hash from url params
     *
     * @param $secret
     * @param array $params
     * @return string
     */
    public function generateSecureSecretHash($secret, array $params)
    {
        $secureHash = "";

        // Sorting params first based on the keys
        ksort($params);

        foreach ($params as $key => $value)
        {
            // Check if key equals to vpc_SecureHash or vpc_SecureHashType to discard it
            if(in_array($key, array('vpc_SecureHash', 'vpc_SecureHashType'))) continue;

            // If key either starts with vpc_ or user_
            if(substr( $key, 0, 4 ) === "vpc_" || substr($key, 0, 5) === "user_") {

                $secureHash .= $key."=".urlencode($value)."&";
            }
        }

        // Remove the last `&` character from string
        $secureHash = rtrim($secureHash, "&");

        //
        return strtoupper(hash_hmac('sha256', $secureHash, pack('H*', $secret)));
    }

    /**
     * A simple algorithm to generate a random reference to the order
     * @return int
     */
    public function generateMerchTxnRef()
    {
        return rand(99999999, 9999999999999999);
    }

} 