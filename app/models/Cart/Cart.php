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
    public function __construct(ProductOffer $productOffers, MassOffer $massOffer, array $items, array $gifts)
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
     * @throws CartException
     * @return bool
     */
    public function hardValidate()
    {
        $numberOfItems     = $this->getItemsQuantity();
        $numberOfGifts     = $this->getGiftsQuantity();
        $giftsMaximumPrice = $this->getGiftsMaximumPrice();

        if(! $this->massOffer->validateGifts($numberOfItems, $numberOfGifts, $giftsMaximumPrice))
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
     * @return float
     */
    public function getTotalPrice()
    {
        $price = 0;

        foreach($this->items as $item)
        {
            $price += $item->getPrice()->value() * $item->getQuantity();
        }

        if($this->massOffer->appliesTo($this->items))
        {
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

    /**
     * @return Price
     */
    protected function getGiftsMaximumPrice()
    {
        if(count($this->gifts) === 0) return new Price(0);

        $maximum = $this->gifts[0]->getPrice();

        for($i = 0; $i < count($this->gifts) - 1; $i++)
        {
            if($this->gifts[$i]->getPrice()->compare($maximum, function($p1, $p2)
            {
                return $p1 > $p2;
            }))
            {
                $maximum = $this->gifts[$i]->getPrice();
            }
        }

        return $maximum;
    }

}