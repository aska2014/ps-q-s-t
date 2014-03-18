<?php namespace Units;

use ECommerce\Product;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Offers\MassOffer;

class Price {

    /**
     * @var string
     */
    public static $defaultCurrency = 'QAR';

    /**
     * @var Currency
     */
    protected $currency;

    /**
     * @var float
     */
    protected $value;

    /**
     * @var ConversionPrice
     */
    protected $conversion;

    /**
     * @param $value
     * @param ConversionPrice $conversion
     * @param \Units\Currency $currency
     * @return \Units\Price
     */
    public function __construct($value, ConversionPrice $conversion, Currency $currency)
    {
        $this->currency = $currency;

        $this->conversion = $conversion;

        $this->calculateValue($value, $this->currency);

        // Prices are rounded
        $this->round(0);
    }

    /**
     * @param $value
     * @return mixed
     */
    public static function make($value, $test = false)
    {
        if($test)
        {
            dd($value);
        }
        return App::make('Units\Price', array($value));
    }

    /**
     * @param $value
     * @param $currency
     */
    public function calculateValue($value, $currency)
    {
        // Convert from default currency to this currency
        $this->value = $this->conversion->convertFromDefault($value, $currency);
    }

    /**
     * @param $price
     * @return Price
     *
     * @return $this
     * @todo Make sure they have the same currencies first
     */
    public function multiply( $price )
    {
        $this->value = $this->extractValue($price) * $this->value;

        return $this;
    }

    /**
     * @param $price
     * @return $this
     */
    public function add( $price )
    {
        $this->value = $this->extractValue($price) + $this->value;

        return $this;
    }

    /**
     * @param $price
     * @return $this
     */
    public function subtract( $price )
    {
        $this->value = $this->extractValue($price) - $this->value;

        return $this;
    }

    /**
     * @param $price
     * @return $this
     */
    public function divide( $price )
    {
        $this->value = $this->value / $price;

        return $this;
    }

    /**
     * @param Price $price
     * @return bool
     */
    public function greaterThan(Price $price)
    {
        return $this->compare($price, function($p1, $p2)
        {
            return $p1 > $p2;
        });
    }

    /**
     * @param Price $price
     * @return bool
     */
    public function greaterThanOrEqual(Price $price)
    {
        return $this->compare($price, function($p1, $p2)
        {
            return $p1 >= $p2;
        });
    }

    /**
     * @param Price $price
     * @return bool
     */
    public function smallerThan(Price $price)
    {
        return $this->compare($price, function($p1, $p2)
        {
            return $p1 < $p2;
        });
    }

    /**
     * @param Price $price
     * @return bool
     */
    public function smallerThanOrEqual(Price $price)
    {
        return $this->compare($price, function($p1, $p2)
        {
            return $p1 <= $p2;
        });
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