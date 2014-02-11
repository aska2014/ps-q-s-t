<?php namespace Cart;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class CookieFactory implements ItemFactoryInterface {

    const ITEM_COOKIE_KEY = '*8u9fijCX<ASD@#';
    const GIFT_COOKIE_KEY = '*(FIUJCKX<ASD@#';

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

        return $this->loaded['gifts'] = $this->generateItemsFromJson($this->getItemsCookies());
    }

    /**
     * Removes items cookie
     */
    public function destroy()
    {
        setcookie(self::ITEM_COOKIE_KEY, "", time()-3600);
        setcookie(self::GIFT_COOKIE_KEY, "", time()-3600);
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
                    return Item::make($item->id, $item->quantity, $item->price);
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
        return isset($_COOKIE[self::ITEM_COOKIE_KEY]) ? $_COOKIE[self::ITEM_COOKIE_KEY] : array();
    }

    /**
     * @return array
     */
    protected function getGiftsCookies()
    {
        return isset($_COOKIE[self::GIFT_COOKIE_KEY]) ? $_COOKIE[self::GIFT_COOKIE_KEY] : array();
    }
}