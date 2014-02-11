<?php namespace Offers;

use Units\Price;

class MassOffer extends \BaseModel {

    /**
     * @var string
     */
    protected $table = 'mass_offers';

    /**
     * @param $query
     * @param $date
     * @return mixed
     */
    public function scopeCurrent($query, $date)
    {
        if($date instanceof \DateTime) $date = $date->format('Y-m-d H:i:s');

        return $query->where('from_date', '<=', $date)
                     ->where('to_date', '>=', $date);
    }

    /**
     * @param $noOfProducts
     * @param $noOfGifts
     * @param Price $maximumPrice
     * @param $date
     * @return bool
     */
    public static function validateGifts($noOfProducts, $noOfGifts, Price $maximumPrice, $date)
    {
        $massOffer = static::current($date)->first();

        return $massOffer->calculateNumberOfGifts($noOfProducts) == $noOfGifts &&

               $massOffer->max_gift_price->compare($maximumPrice, function($p1, $p2) {

                   return $p1 > $p2;
               });
    }

    /**
     * @param $count
     * @return int
     */
    public function calculateNumberOfGifts($count)
    {
        return floor($this->gifts_per_product * $count);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function maxGiftPrice(){ return $this->belongsTo(Price::getClass()); }

}