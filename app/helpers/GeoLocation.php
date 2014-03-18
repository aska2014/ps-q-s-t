<?php

class GeoLocation {

    /**
     * @return string
     */
    public function getCurrencyCode()
    {
        $ip_data = $this->getGeo();

        if($ip_data && $ip_data->geoplugin_currencyCode != null)
        {
            return $ip_data->geoplugin_currencyCode;
        }
    }

    /**
     * @return bool
     */
    public function isEgypt()
    {
        return $this->getCountryName() === 'Egypt';
    }

    /**
     * @return string
     */
    public function getCountryName()
    {
        $ip_data = $this->getGeo();

        if($ip_data && $ip_data->geoplugin_countryName != null)
        {
            return $ip_data->geoplugin_countryName;
        }
    }

    /**
     * Return country name
     *
     * @return stdClass
     */
    protected function getGeo()
    {
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];

        if(filter_var($client, FILTER_VALIDATE_IP))
        {
            $ip = $client;
        }
        elseif(filter_var($forward, FILTER_VALIDATE_IP))
        {
            $ip = $forward;
        }
        else
        {
            $ip = $remote;
        }

        $ip_data = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip));

        return $ip_data;
    }

} 