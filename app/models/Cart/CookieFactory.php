<?php namespace Cart;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class CookieFactory implements ItemFactoryInterface {

    const ITEM_COOKIE_KEY = 'rijekfd';
    const GIFT_COOKIE_KEY = 'trcbsdfg';

    protected $loaded;

    /**
     * @return Item[]
     */
    public function makeItems()
    {
        if(isset($this->loaded['items'])) return $this->loaded['items'];

        return $this->loaded['items'] = $this->generateItemsFromJson($this->getItemsCookies());
    }

    /**
     * @return Item[]
     */
    public function makeGifts()
    {
        if(isset($this->loaded['gifts'])) return $this->loaded['gifts'];

        return $this->loaded['gifts'] = $this->generateItemsFromJson($this->getGiftsCookies());
    }

    /**
     * Removes items cookie
     */
    public function destroy()
    {
        setcookie(self::ITEM_COOKIE_KEY, "", time()-3600, "/");
        setcookie(self::GIFT_COOKIE_KEY, "", time()-3600, "/");
    }

    /**
     * Regenerate items and gifts
     *
     * @return void
     */
    public function regenerate()
    {
        $items = $this->makeItems();

        $gifts = $this->makeGifts();

        $this->setItems($items);

        $this->setGifts($gifts);
    }

    /**
     * @param Item[] $items
     * @return mixed
     */
    public function setItems(array $items)
    {
        $this->replaceCookieWithItems(static::ITEM_COOKIE_KEY, $items);
    }

    /**
     * @param Item[] $gifts
     * @return mixed
     */
    public function setGifts(array $gifts)
    {
        $this->replaceCookieWithItems(static::GIFT_COOKIE_KEY, $gifts);
    }

    /**
     * @param $cookieName
     * @param Item[] $items
     */
    protected function replaceCookieWithItems($cookieName, array $items)
    {
        $array = array();

        foreach($items as $item)
        {
            $object = new \stdClass();

            $object->id = $item->getProduct()->id;
            $object->quantity = $item->getQuantity();
            $object->price = $item->getPrice()->value();

            $array[] = $object;
        }

        setcookie($cookieName, json_encode($array), time() + 20*365, '/');
    }

    /**
     * @param $json
     * @param $json
     * @throws CartException
     * @return Item[]
     */
    protected function generateItemsFromJson( $json )
    {
        $array = json_decode($json);

        if(is_array($array))
        {
            return array_map(function($item) {

                try{
                    return Item::make($item->id, $item->quantity);
                }catch(ModelNotFoundException $e) {
                    throw new CartException("Some products in your cart where not found. There's a chance the product has been deleted from our stock after you added it in your cart.");
                }

            }, $array);
        }

        return array();
    }

    /**
     * @return array
     */
    protected function getItemsCookies()
    {
        return isset($_COOKIE[self::ITEM_COOKIE_KEY]) ? $_COOKIE[self::ITEM_COOKIE_KEY] : '';
    }

    /**
     * @return array
     */
    protected function getGiftsCookies()
    {
        return isset($_COOKIE[self::GIFT_COOKIE_KEY]) ? $_COOKIE[self::GIFT_COOKIE_KEY] : '';
    }
}