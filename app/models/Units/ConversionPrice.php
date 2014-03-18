<?php namespace Units;

use Illuminate\Support\Facades\Session;

class ConversionPrice {

    /**
     * @var Currency
     */
    protected $defaultCurrency;

    /**
     * If we couldn't use the conversion algorithm we will use this as a default value
     *
     * @var array
     */
    protected $defaultRates = array(

        'QAR_EGP' => '1.91'
    );

    /**
     * @var array
     */
    protected $loadedRates = array();

    /**
     * @param $defaultCurrency
     */
    public function __construct($defaultCurrency)
    {
        $this->defaultCurrency = $defaultCurrency;
    }

    /**
     * @param $value
     * @param $toCurrency
     * @return float
     */
    public function convertFromDefault($value, Currency $toCurrency)
    {
        // Convert from default currency to the given currency
        return $this->convert($value, $this->defaultCurrency, $toCurrency);
    }

    /**
     * @param $value
     * @param $fromCurrency
     * @param $toCurrency
     * @return mixed
     */
    public function convert($value, Currency $fromCurrency, Currency $toCurrency)
    {
        if($fromCurrency->equals($toCurrency)) return $value;

        return $this->loadRate($fromCurrency, $toCurrency) * $value;
    }

    /**
     * @param $from
     * @param $to
     * @throws PriceConversionException
     * @return mixed
     */
    protected function loadRate($from, $to)
    {
        // If this conversion rate was loaded before then return it.
        if($this->hasLoadedRate($from, $to))
        {
            return $this->getLoadedRate($from, $to);
        }

        // If this rate is in session then load it from session
        elseif($rate = $this->getFromSession($from, $to)) {

            $this->setLoadedRate($from, $to, $rate);

            return $rate;
        }

        // Try to get the rate from online conversion sites..
        elseif($rate = $this->getOnlineRate($from, $to))
        {
            $this->setLoadedRate($from, $to, $rate);

            $this->saveToSession($from, $to, $rate);

            return $rate;
        }

        // Return default conversion rate
        elseif($rate = $this->getDefaultRate($from, $to))
        {
            $this->setLoadedRate($from, $to, $rate);

            return $rate;
        }

        throw new PriceConversionException("We couldn't convert to this currency");
    }

    /**
     * @param $from
     * @param $to
     * @return bool
     */
    protected function getOnlineRate($from, $to)
    {
        try{
            $object = json_decode(file_get_contents('http://rate-exchange.appspot.com/currency?from='.$from.'&to='.$to));

            return $object->rate;

        }catch(\Exception $e){

            return false;
        }
    }

    /**
     * @param $from
     * @param $to
     * @return string
     */
    protected function fromToFormat($from, $to)
    {
        return "{$from}_{$to}";
    }

    /**
     * @param $from
     * @param $to
     * @return mixed
     */
    protected function getDefaultRate($from, $to)
    {
        return $this->defaultRates[$this->fromToFormat($from, $to)];
    }

    /**
     * @param $from
     * @param $to
     * @return mixed
     */
    protected function getLoadedRate($from, $to)
    {
        return $this->loadedRates[$this->fromToFormat($from, $to)];
    }

    /**
     * @param $from
     * @param $to
     * @return bool
     */
    protected function hasLoadedRate($from, $to)
    {
        return isset($this->loadedRates[$this->fromToFormat($from, $to)]);
    }

    /**
     * @param $from
     * @param $to
     * @param $rate
     */
    protected function setLoadedRate($from, $to, $rate)
    {
        $this->loadedRates[$this->fromToFormat($from, $to)] = $rate;
    }

    /**
     * @param $from
     * @param $to
     * @param $rate
     */
    protected function saveToSession($from, $to, $rate)
    {
        Session::put('conversion_rate_'.$this->fromToFormat($from, $to), $rate);
    }


    /**
     * @param $from
     * @param $to
     * @return mixed
     */
    protected function getFromSession($from, $to)
    {
        return Session::get('conversion_rate_'.$this->fromToFormat($from, $to), false);
    }
}