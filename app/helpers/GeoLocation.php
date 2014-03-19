<?php

class GeoLocation {

    /**
     * @return bool
     */
    public function isEgypt()
    {
        return $this->getCountryCode() === 'EG';
    }

    /**
     * @return mixed
     */
    public function getCountryCode()
    {
        return $this->extractFromGeo('geoplugin_countryCode');
    }

    /**
     * Return country currency code
     *
     * @return string
     */
    public function getCurrencyCode()
    {
        return $this->extractFromGeo('geoplugin_currencyCode');
    }

    /**
     * Return country name
     *
     * @return string
     */
    public function getCountryName()
    {
        return $this->extractFromGeo('geoplugin_countryName');
    }

    /**
     * @param $variable
     * @return string
     */
    protected function extractFromGeo($variable)
    {
        $geo = $this->getGeo();

        if(isset($geo->$variable) && $geo->$variable != null)
        {
            return $geo->$variable;
        }
    }

    /**
     * Return Geo data
     *
     * @return stdClass
     */
    protected function getGeo()
    {
        if($ipData = $this->getFromSession())
        {
            return $ipData;
        }

        if($ipData = $this->getFromSite())
        {
            $this->saveToSession($ipData);

            return $ipData;
        }
    }

    /**
     * @return stdClass
     */
    protected function getFromSite()
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

    /**
     * @return mixed
     */
    protected function getFromSession()
    {
        return Session::get('ip_information');
    }

    /**
     * @param $ip_data
     */
    protected function saveToSession($ip_data)
    {
        Session::put('ip_information', $ip_data);
    }
} 