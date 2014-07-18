<?php namespace Units;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class Currency {

    /**
     * @var array
     */
    protected static $available = array('EGP', 'QAR', 'USD');

    /**
     * @var string
     */
    protected static $default = 'QAR';

    /**
     * @var string
     */
    protected static $currentCurrency;

    /**
     * @var string
     */
    protected $currency;

    /**
     * @param $currency
     * @throws CurrencyException
     */
    public function __construct($currency)
    {
        $currency = strtoupper($currency);

        if(! in_array($currency, static::$available))
        {
            throw new CurrencyException("This currency:" .$currency." is not available yet in our application");
        }

        $this->currency = $currency;
    }

    /**
     * @return array
     */
    public static function getAvailable()
    {
        return static::$available;
    }

    /**
     * @return Currency
     */
    public static function getDefault()
    {
        return new static(static::$default);
    }

    /**
     * @return Currency
     */
    public static function getCurrent()
    {
        if(static::$currentCurrency)
        {
            return new Currency(static::$currentCurrency);
        }

        // Try to get the currency from the session
        if($currency = Session::get('application_currency', false))
        {
            return new Currency($currency);
        }

        // Try to set currency from the country currency code.
        try{
            $currencyCode = App::make('GeoLocation')->getCurrencyCode();

            Session::put('application_currency', $currencyCode);

            return new Currency($currencyCode);

            // Return default currency
        }catch(\Units\CurrencyException $e) {

            Session::put('application_currency', 'QAR');

            return new Currency('QAR');
        }
    }

    /**
     * @param $currentCurrency
     */
    public static function setCurrent($currentCurrency)
    {
        static::$currentCurrency =  $currentCurrency;
    }

    /**
     * @param $currencyCode
     * @return bool
     */
    public static function isAvailable($currencyCode)
    {
        return in_array(strtoupper($currencyCode), static::$available);
    }

    /**
     * @param Currency $currency
     * @return bool
     */
    public function equals(Currency $currency)
    {
        return $this->__toString() == $currency->__toString();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->currency;
    }
}