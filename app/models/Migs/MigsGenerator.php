<?php namespace Migs;

class MigsGenerator {

    /**
     * Get settings
     *
     * @param MigsAccount $account
     * @param $amount
     * @param $currency
     * @param $orderUniqueId
     * @param string $returnUrl
     * @return array
     */
    public function getQueryData(MigsAccount $account, $amount, $currency, $orderUniqueId, $returnUrl = '')
    {
        $orderInfo = 'Paying for order #'.$orderUniqueId;

        $data = array(
            'vpc_AccessCode' => $account->access_code,
            'vpc_Merchant' => $account->merchant_id,

            'vpc_Amount' => ($amount * 100), // Multiplying by 100 to convert to the smallest unit
            'vpc_Currency' => $currency,
            'vpc_OrderInfo' => $orderInfo,

            'vpc_MerchTxnRef' => $orderUniqueId,

            'vpc_Command' => 'pay',
            'vpc_Locale' => 'ar',
            'vpc_Version' => 1,

//            'vpc_SecureHashType' => 'SHA256'
        );

        if($returnUrl) $data['vpc_ReturnURL'] = $returnUrl;

        $data['vpc_SecureHash'] = $this->generateMd5SecureSecretHash($account->secret, $data);

        return $data;
    }

    /**
     * @param $secret
     * @param array $params
     * @return string
     */
    protected function generateMd5SecureSecretHash($secret, array $params)
    {
        $secureHash = $secret;

        ksort($params);

        foreach($params as $key => $value)
        {
            if(in_array($key, array('vpc_SecureHash', 'vpc_SecureHashType'))) continue;

            // If key either starts with vpc_ or user_
            if(substr( $key, 0, 4 ) === "vpc_" || substr($key, 0, 5) === "user_") {

                $secureHash .= $value;
            }
        }

        return strtoupper(md5($secureHash));
    }

    /**
     * Generate secure hash from url params
     *
     * @param $secret
     * @param array $params
     * @return string
     */
    public function generateSha256SecureSecretHash($secret, array $params)
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

} 