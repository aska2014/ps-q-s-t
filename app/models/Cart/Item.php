<?php namespace Cart;

use ECommerce\Product;
use Units\Price;

class Item {

    /**
     * @var Product
     */
    protected $product;

    /**
     * @var int
     */
    protected $quantity;

    /**
     * @param $product
     * @param $quantity
     */
    public function __construct($product, $quantity)
    {
        $this->product = $product;
        $this->quantity = $quantity;
    }

    /**
     * @param $id
     * @param $quantity
     * @return Item
     */
    public static function make($id, $quantity)
    {
        return new static(Product::findOrFail($id), $quantity);
    }

    /**
     * @return Price
     */
    public function getPrice()
    {
        return $this->product->getOfferPrice();
    }

    /**
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @return Price
     */
    public function getSubTotal()
    {
        $price = clone $this->getPrice();

        return $price->multiply($this->getQuantity());
    }
}