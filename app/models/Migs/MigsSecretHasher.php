<?php namespace Migs;

class MigsSecretHasher {

    /**
     * @param MigsAccount $account
     * @param $params
     * @return string
     */
    public function md5(MigsAccount $account, $params)
    {
        $secureHash = $account->secret;

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
     * @param MigsAccount $account
     * @param $params
     * @return string
     */
    public function sha256(MigsAccount $account, $params)
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
        return strtoupper(hash_hmac('sha256', $secureHash, pack('H*', $account->secret)));
    }

} 