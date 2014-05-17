<?php namespace Offers;

use Cart\Item;
use ECommerce\Product;
use Illuminate\Support\Collection;
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
     * Make default offer
     */
    public static function makeDefaultOffer()
    {
        static::where('gifts_per_product', '=', 0.5)->update(array(
            'from_date' => date('Y-m-d H:i:s', strtotime('now')),
            'to_date'   => date('Y-m-d H:i:s', strtotime('+7 days'))
        ));
    }

    /**
     * @param Item[] $items
     * @param Item[] $gifts
     * @return bool
     */
    public function validateGifts($items, $gifts)
    {
        foreach($gifts as $gift)
        {
            // If the maximum gift price defined is smaller than any of the gift prices then return false
            if($this->getMaxGiftPrice()->smallerThan($gift->getPrice())) {

                return false;
            }
        }

        return $this->calculateNumberOfGifts($items) >= count($gifts);
    }

    /**
     * @param Collection $products
     * @return array
     */
    public function filterGiftsFromCollection($products)
    {
        return $products->filter(function(Product $product)
        {
            return $product->getOfferPrice()->smallerThanOrEqual($this->getMaxGiftPrice());
        });
    }

    /**
     * @param Item[] $items
     * @return int
     */
    public function calculateNumberOfGifts($items)
    {
        return floor($this->gifts_per_product * $this->calculateQuantity($items));
    }

    /**
     * @param Item[] $items
     * @return int
     */
    protected function calculateQuantity($items)
    {
        $quantity = 0;

        foreach($items as $item)
        {
            $quantity += $item->getQuantity();
        }

        return $quantity;
    }

    /**
     * @param Item[] $items
     * @return bool
     */
    public function appliesTo(array $items)
    {
        $total = Price::make(0);

        foreach($items as $item)
        {
            $total->add($item->getSubTotal());
        }

        // If number of items greater than start quantity and total greater than or equal start price
        return count($items) >= $this->start_quantity && $total->greaterThanOrEqual($this->getStartPrice());
    }

    /**
     * @param Price $price
     * @return Price
     */
    public function calculatePriceFrom(Price $price)
    {
        $price = clone $price;

        return $price->multiply(1 - ($this->discount_percentage / 100));
    }

    /**
     * @return Price
     */
    public function getMaxGiftPrice()
    {
        if(isset($this->prices['max_gift'])) return $this->prices['max_gift'];

        return $this->prices['max_gift'] = Price::make($this->max_gift_price);
    }

    /**
     * @return \Units\Price
     */
    public function getStartPrice()
    {
        if(isset($this->prices['start'])) return $this->prices['start'];

        return $this->prices['start'] = Price::make($this->start_price);
    }

}