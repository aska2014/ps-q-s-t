<?php namespace Cart;

use Offers\MassOffer;
use Offers\ProductOffer;
use Units\Price;

class Cart {

    /**
     * @var \Offers\MassOffer
     */
    protected $massOffer;

    /**
     * @var \Offers\ProductOffer
     */
    protected $productOffers;

    /**
     * @var Item[]
     */
    protected $gifts;

    /**
     * @var Item[]
     */
    protected $items;

    /**
     * @param \Offers\ProductOffer $productOffers
     * @param \Offers\MassOffer $massOffer
     * @param array $items
     * @param array $gifts
     */
    public function __construct(array $items, array $gifts, ProductOffer $productOffers, MassOffer $massOffer = null)
    {
        $this->massOffer = $massOffer;
        $this->productOffers = $productOffers;
        $this->items = $items;
        $this->gifts = $gifts;
    }

    /**
     * @param array $gifts
     */
    public function setGifts(array $gifts)
    {
        $this->gifts = $gifts;
    }

    /**
     * @param array $items
     * @param array $items
     */
    public function setItems(array $items)
    {
        $this->items = $items;
    }

    /**
     * @return Item[]
     * @return array|\Cart\Item[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @return Item[]
     */
    public function getGifts()
    {
        return $this->gifts;
    }

    /**
     * @return bool
     */
    public function hasGifts()
    {
        return count($this->gifts) > 0;
    }

    /**
     * @throws CartException
     * @return bool
     */
    public function hardValidate()
    {
        if(is_null($this->massOffer) && $this->hasGifts())
        {
            throw new CartException('We current don\'t have any special offers so you cant have gifts in your cart.');
        }

        // If there's mass offer and gift validation is false
        elseif($this->massOffer && !$this->massOffer->validateGifts($this->getItems(), $this->getGifts()))
        {
            throw new CartException('Something went wrong while trying to validate gifts in the cart.');
        }
    }

    /**
     * @return int
     */
    public function getItemsQuantity()
    {
        return $this->calculateQuantity($this->items);
    }

    /**
     * @return int
     */
    public function getGiftsQuantity()
    {
        return $this->calculateQuantity($this->gifts);
    }

    /**
     * @return Price
     */
    public function getTotalPrice()
    {
        $price = new Price(0);

        // Add subtotals
        foreach($this->items as $item)
        {
            $price->add($item->getSubTotal());
        }

        // Check if there's mass offer and it applies on this items
        if($this->massOffer && $this->massOffer->appliesTo($this->items))
        {
            // Calculate price from mass offer
            return $this->massOffer->calculatePriceFrom($price);
        }

        return $price;
    }

    /**
     * @param Item[] $items
     * @return int
     */
    protected function calculateQuantity( array $items )
    {
        $quantity = 0;

        foreach($items as $item)
        {
            $quantity += $item->getQuantity();
        }

        return $quantity;
    }

}