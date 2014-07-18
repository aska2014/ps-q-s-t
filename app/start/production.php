<?php


use Paypal\PaypalException;

function readableArray($array, $concat = '<br />')
{
    $string = '';

    foreach($array as $key => $value)
    {
        if(is_array($value))
        {
            $string .=  $key .'= ['.readableArray($value, ';').']' . $concat;
        }

        else
        {
            $string .= $key .'=' . $value . $concat;
        }
    }
    return $string;
}

$sendMailWithException = function(Exception $exception, $code)
{
    $data = array(
        'errorTitle' => get_class($exception) . ' <br />' . $exception->getMessage(),
        'errorDescription' => 'In file:' . $exception->getFile() . ', In line:'.$exception->getLine() . '',
        'errorPage' => Request::url() . ' : ' . Request::getMethod() . '<br /><br />INPUTS ARE: <br />' . readableArray(Input::all())
    );

    Mail::send('emails.error', $data, function($message)
    {
        $message->to('kareem3d.a@gmail.com', 'Kareem Mohamed')->subject('Error from qbrando');
    });
};

App::error(function(Exception $e, $code) use($sendMailWithException)
{
    call_user_func_array($sendMailWithException, array($e, $code));

    return Redirect::route('message-to-user')
        ->with('title', 'Whoops! Something went wrong.')

        ->with('body', 'Something went wrong while trying to process your request :(');
});

App::error(function(Illuminate\Database\Eloquent\ModelNotFoundException $e, $code)
{
    $contactUs = App::make('\Website\ContactUs');

    return Redirect::route('message-to-user')
        ->with('title', 'We can\'t find this product in our stock :(')

        ->with('body', 'Feel free to contact us at <strong>' . $contactUs->getMobileNumber() . '</strong><br />
        Or Email us: <strong>' . $contactUs->getEmailAddress() . '</strong>');
});

App::error(function(PaypalException $e, $code) use($sendMailWithException)
{
    $data = array(
        'errorTitle' => get_class($e) . ' <br />' . $e->getMessage(),
        'errorDescription' => 'In file:' . $e->getFile() . ', In line:'.$e->getLine() . '',
        'errorPage' => Request::url() . ' : ' . Request::getMethod() . '<br /><br />
                        INPUTS ARE: <br />' . readableArray(Input::all()) . '
                        <br/><br/>Request: <br/>'.var_export($e->getRequest(), true).'
                        <br/><br/>Response: <Br/>'.var_export($e->getResponse(), true)
    );

    Mail::send('emails.error', $data, function($message)
    {
        $message->to('kareem3d.a@gmail.com', 'Kareem Mohamed')->subject('Error from qbrando');
    });

    return Redirect::route('message-to-user')
        ->with('title', 'Something went wrong while trying to pay with Paypal')

        ->with('message', 'Please try again. If this error still occurs choose another payment method.');
});


App::missing(function($exception)
{
    return 'Sorry the page you are looking for not found. go to <a href="'.URL::route('home').'">Qbrando home page</a>';
});