<?php namespace Cart;

use Offers\MassOffer;
use Offers\ProductOffer;
use Units\Price;

class Cart {

    /**
     * @var \Offers\MassOffer
     */
    protected $massOffers;

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
     * @param \Offers\MassOffer $massOffers
     * @param array $items
     * @param array $gifts
     */
    public function __construct(ProductOffer $productOffers, MassOffer $massOffers, array $items, array $gifts)
    {
        $this->massOffers = $massOffers;
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

        if(! $this->massOffers->validateGifts($numberOfItems, $numberOfGifts, $giftsMaximumPrice, new \DateTime('now')))
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
     * @param array $items
     * @return int
     */
    protected function calculateQuantity( array $items )
    {
        $quantity = 0;

        foreach($items as $item)
        {
            $quantity += $item->quantity;
        }

        return $quantity;
    }

    /**
     * @return Price
     */
    protected function getGiftsMaximumPrice()
    {
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