<?php namespace Units;

use ECommerce\Product;
use Offers\MassOffer;

class Price extends \BaseModel {

    /**
     * @var string
     */
    protected $table = 'prices';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    public static $defaultCurrency = 'QAR';

    /**
     * @return mixed|void
     */
    public function beforeSave()
    {
        if(! $this->currency)
        {
            $this->currency = static::$defaultCurrency;
        }
    }

    /**
     * @param $value
     */
    public function setValueAttribute($value)
    {
        $this->attributes['value'] = str_replace(',', '', $value);
    }

    /**
     * @return string
     */
    public function format()
    {
        return "{$this->currency} {$this->value}";
    }

    /**
     * @param $value
     * @return mixed
     */
    public function multiply( $value )
    {
        $this->value = $this->extractValue($value) * $this->value;
    }

    /**
     * @param $value
     * @return string
     */
    public function getValueAttribute($value)
    {
        return number_format($value, 2);
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

    /**
     * @param $x
     * @return mixed
     */
    protected function extractValue( $x )
    {
        if($x instanceof Price) return $x->value;

        return $x;
    }

    /**
     * Defining relations
     */
    public function product(){ return $this->hasOne(Product::getClass()); }
    public function massOffer(){ return $this->hasMany(MassOffer::getClass()); }

}