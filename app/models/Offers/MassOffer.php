<?php namespace Offers;

use Cart\Item;
use Units\Price;

class MassOffer extends \DateRangeModel {

    /**
     * @var string
     */
    protected $table = 'mass_offers';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $prices = array();

    /**
     * @param $noOfProducts
     * @param $noOfGifts
     * @param Price $maximumPrice
     * @return bool
     */
    public function validateGifts($noOfProducts, $noOfGifts, Price $maximumPrice)
    {
        return $this->calculateNumberOfGifts($noOfProducts) >= $noOfGifts &&

                $this->getMaxGiftPrice()->compare($maximumPrice, function($p1, $p2) {

                   return $p1 >= $p2;
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
     * @param Item[] $items
     * @return bool
     */
    public function appliesTo(array $items)
    {
        return $this->start_quantity >= count($items);
    }

    /**
     * @param $price
     * @return float
     */
    public function calculatePriceFrom($price)
    {
        return $price * (1 - ($this->discount_percentage / 100));
    }

    /**
     * @return Price
     */
    public function getMaxGiftPrice()
    {
        if(isset($this->prices['max_gift'])) return $this->prices['max_gift'];

        return $this->prices['max_gift'] = new Price($this->max_gift_price);
    }

    /**
     * @return \Units\Price
     */
    public function getStartPrice()
    {
        if(isset($this->prices['start'])) return $this->prices['start'];

        return $this->prices['start'] = new Price($this->start_price);
    }

}