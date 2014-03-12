<?php namespace Cachna;

use Illuminate\Support\Facades\Config;

class Client {

    /**
     * @var string
     */
    protected $webServiceUrl;

    /**
     * @var array
     */
    protected $account;

    /**
     * @param $webServiceUrl
     * @param $account
     */
    public function __construct($webServiceUrl, $account)
    {
        $this->webServiceUrl = $webServiceUrl;
        $this->account = $account;
    }

    /**
     * @return static
     */
    public static function makeFromConfig()
    {
        return new static(Config::get('cachna.url'), Config::get('cachna.account'));
    }

    /**
     * @param $amount
     * @param string $currency
     * @param string $remarks
     */
    public function sendRequest($amount, $currency = 'USD', $remarks = '')
    {
        $client = new \SoapClient($this->webServiceUrl);

        $options = array_merge($this->account, compact('amount', 'currency', 'remarks'));

        $result = $client->ValidateMerchant($options);

        $return = $result->ValidateMerchantResult;

        dd($return);
    }

} 