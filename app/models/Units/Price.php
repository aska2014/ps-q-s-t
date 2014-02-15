<?php namespace Units;

use ECommerce\Product;
use Offers\MassOffer;

class Price {

    /**
     * @var string
     */
    public static $defaultCurrency = 'QAR';

    /**
     * @var string
     */
    protected $currency;

    /**
     * @var float
     */
    protected $value;

    /**
     * @param $value
     * @param string $currency
     * @return \Units\Price
     */
    public function __construct($value, $currency = '')
    {
        $this->currency = $currency ?: static::$defaultCurrency;

        $this->value = $value;

        $this->round(2);
    }

    /**
     * @param $price
     * @return Price
     *
     * @todo Make sure they have the same currencies first
     */
    public function multiply( $price )
    {
        $this->value = $this->extractValue($price) * $this->value;

        return $this;
    }

    /**
     * @param int $precision
     * @return Price
     */
    public function round( $precision = 0 )
    {
        $this->value = round($this->value, $precision);

        return $this;
    }

    /**
     * @param $price
     * @return float
     */
    protected function extractValue($price)
    {
        return $price instanceof Price ? $price->value() : $price;
    }

    /**
     * @return float
     */
    public function value()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function format()
    {
        return "{$this->currency} {$this->formattedValue()}";
    }

    /**
     * @return string
     */
    public function formattedValue()
    {
        return number_format($this->value(), 2);
    }

    /**
     * @param Price $price
     * @param \Closure $callback
     * @return bool
     *
     * @todo Make sure that both prices are in the same currencies...
     */
    public function compare(Price $price, \Closure $callback)
    {
        return call_user_func_array($callback, array($this, $price));
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->format();
    }
}