<?php namespace Paypal;

use Units\Price;

class PaypalPayment extends \Kareem3d\Eloquent\Model {

    const AWAITING = 55552;
    const CANCELED = 34113;
    const RECEIVED = 34216;

    /**
     * @var string
     */
    protected $table = 'paypal_payments';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @param $token
     * @return PaypalPayment
     */
    public static function getByToken( $token )
    {
        return static::where('token', $token)->first();
    }

    /**
     * @return Price
     */
    public function getFeeAmount()
    {
        return Price::make($this->attributes['fee_amount'])->setCurrency($this->attributes['currency']);
    }

    /**
     * @return Price
     */
    public function getGrossAmount()
    {
        return Price::make($this->attributes['gross_amount'])->setCurrency($this->attributes['currency']);
    }

    /**
     * Paypal payment canceled
     */
    public function canceled()
    {
        $this->status = self::CANCELED;
    }

    /**
     * Paypal payment received
     */
    public function received()
    {
        $this->status = self::RECEIVED;
    }

    /**
     * Paypal payment awaiting
     */
    public function awaiting()
    {
        $this->status = self::AWAITING;
    }

    /**
     * @return bool
     */
    public function hasReceived()
    {
        return $this->status == self::RECEIVED;
    }

    /**
     * @return bool
     */
    public function hasCanceled()
    {
        return $this->status == self::CANCELED || ($this->awaiting() && $this->timeout() );
    }

    /**
     * @todo
     * @return bool
     */
    public function timeout()
    {
        return false;
    }

    /**
     * @return bool
     */
    public function isAwaiting()
    {
        return $this->status == self::AWAITING;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(\ECommerce\Order::getClass());
    }
}