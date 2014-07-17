<?php

/**
* Show checkout method along with the necessary information.
*/
Route::get('/checkout.html', array('as' => 'checkout', 'uses' => 'ShoppingCartController@checkout'));
/**
* Will create new order and fill its information and check for payment method to continue.
*/
Route::post('/checkout', array('as' => 'checkout.post', 'uses' => 'CheckoutController@postCreateOrder'));





//-------------------------------------- PAYMENT METHOD "MIGS" ----------------------------------------------//
/**
 * Return from migs payment
 */
Route::get('/nbe-return.html', array('as' => 'migs.back', 'uses' => 'MigsPaymentController@back'));
//-------------------------------------- END PAYMENT METHOD ----------------------------------------------//







//-------------------------------------- PAYMENT METHOD "PAYPAL" ----------------------------------------------//
/**
 * Scenario1:
 * checkout -> checkout.post(Payment=paypal) -> create full information order and redirect to paypal
 * if(paypalback is success)
 *      checkout.paypal.succeed -> checkout.confirm_paypal
 * else
 *      checkout.paypal.canceled -> checkout.post AND LOOP AGAIN
 *
 * Scenario2:
 * checkout -> checkout.post(Payment=delivery) -> create full information order -> SUCCESS
 *
 * Scenario3:
 * checkout.paypal -> create empty order and redirect to paypal
 * if(paypalback is success)
 *      checkout.paypal_succeed -> checkout.fill_and_confirm_paypal
 * else
 *      checkout.paypal_canceled -> checkout.post AND LOOP AGAIN
 */

/**
* Checkout with paypal will create an empty order and redirect user to paypal.
* After he is back with success the empty order will be filled.
*/
//Route::get('/checkout-with-paypal.html', array('as' => 'checkout.paypal', 'uses' => 'CheckoutController@checkoutWithPaypal'));
/**
* Paypal has redirected back with success. Here we will ask the user to enter the rest of information we don't know from paypal (if any)
* and click on Pay now to confirm paypal paying and update order information.
*/
Route::get('/paypal-succeed.html', array('as' => 'paypal.succeed', 'uses' => 'PaypalController@backSucceed'));
/**
* Ask for rest of not entered information (if any) and ask him the payment method again.
*/
Route::get('/paypal-canceled.html', array('as' => 'paypal.canceled', 'uses' => 'PaypalController@backCanceled'));
/**
* Confirm paypal order and save rest of information to the specified order.
*/
//Route::post('/fill-and-confirm-paypal-payment.html', array('as' => 'checkout.fill_and_confirm_paypal', 'uses' => 'CheckoutController@postFillAndConfirmPaypalPayment'));
/*** Confirm paypal order and save rest of information to the specified order.
*/
Route::post('/confirm-paypal-payment.html', array('as' => 'checkout.paypal.confirm', 'uses' => 'PaypalController@postConfirmPayment'));
//-------------------------------------- END PAYMENT METHOD ----------------------------------------------//
