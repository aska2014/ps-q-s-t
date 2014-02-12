<?php

class HomeController extends BaseController {

    /**
     * @return mixed
     */
    public function index()
	{
        return View::make('pages.home');
	}

}