<?php

use Illuminate\Support\MessageBag;

class BaseController extends Controller {

    const PRODUCTS_PER_CAROUSEL = 12;
    const PRODUCTS_PER_PAGE = 12;

    /**
     * @var MessageBag
     */
    protected $errors;

    /**
     * @param $title
     * @param $body
     * @return mixed
     */
    protected function messageToUser($title, $body)
    {
        return Redirect::route('message-to-user')->with('title', $title)->with('body', $body);
    }

    /**
     * @param $messages
     */
    protected function addErrors($messages)
    {
        if(! $this->errors) $this->errors = new MessageBag;

        // If it's array then merge it
        if(is_array($messages)) $this->errors->merge($messages);

        if(is_string($messages)) $this->errors->merge(array($messages));

        // If it's message bag then merge it's messages
        if($messages instanceof MessageBag) $this->errors->merge($messages->getMessages());
    }

    /**
     * @return mixed
     */
    protected function emptyErrors()
    {
        return ! $this->errors || $this->errors->isEmpty();
    }

    /**
     * @return MessageBag
     */
    protected function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param \Illuminate\Support\Collection $products
     */
    protected function addToVisible(\Illuminate\Support\Collection $products)
    {
        App::make('VisibleProductRepository')->add($products);
    }

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

    /**
     * @return array
     */
    protected function convertSlugs()
    {
        $array = array();
        $slugs = func_get_args();

        foreach($slugs as $slug)
        {
            array_push($array, URL::decode($slug));
        }

        return count($array) == 1 ? $array[0] : $array;
    }
}