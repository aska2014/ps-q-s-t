<?php namespace Cart;


interface ItemFactoryInterface {

    /**
     * Item factory method.
     *
     * @return Item[]
     */
    public function makeItems();

    /**
     * Gifts factory method.
     *
     * @return Item[]
     */
    public function makeGifts();

    /**
     * @param array $items
     * @return mixed
     */
    public function setItems(array $items);

    /**
     * @param array $gifts
     * @return mixed
     */
    public function setGifts(array $gifts);

    /**
     * Regenerate items and gifts
     *
     * @return void
     */
    public function regenerate();

    /**
     * Destroy all item storage
     *
     * @return mixed
     */
    public function destroy();
}