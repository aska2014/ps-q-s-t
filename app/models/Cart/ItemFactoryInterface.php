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
     * Destroy all item storage
     *
     * @return mixed
     */
    public function destroy();
}