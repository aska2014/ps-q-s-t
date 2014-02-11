<?php namespace Kareem3d\Responser;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response as LaravelResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\MessageBag;

class Response {

    const SUCCESS_KEY = '*#YIUEKJFSDC';
    const ERRORS_KEY = 'Y&#RHEFVCX#$';

    /**
     * @return MessageBag
     */
    public static function getSuccess()
    {
        return new MessageBag((array) Session::get(self::SUCCESS_KEY, array()));
    }

    /**
     * @return MessageBag
     */
    public static function getErrors()
    {
        return new MessageBag((array) Session::get(self::ERRORS_KEY, array()));
    }

    /**
     * @param $success
     * @param $page
     * @return mixed
     */
    public static function success($success, $page = false)
    {
        $success = static::toMessageBag($success);

        if (Request::ajax())
        {
            return LaravelResponse::make($success->all("\n"), 200);
        }

        return static::redirectToPage($page)->with(self::SUCCESS_KEY, $success->toArray());
    }

    /**
     * @param $errors
     * @param $page
     * @return mixed
     */
    public static function errors($errors, $page = false)
    {
        $errors = static::toMessageBag($errors);

        if (Request::ajax())
        {
            return LaravelResponse::make($errors->all("\n"), 406);
        }

        return static::redirectToPage($page)->with(self::ERRORS_KEY, $errors->toArray());
    }

    /**
     * @param $page
     * @return mixed
     */
    protected static function redirectToPage($page)
    {
        return $page === false ? Redirect::back() : Redirect::to($page);
    }

    /**
     * @param $messages
     * @return array
     */
    protected static function toArray($messages)
    {
        if($messages instanceof MessageBag)
        {
            return $messages->getMessages();
        }

        if(is_string($messages))
        {
            return array($messages);
        }

        return $messages;
    }

    /**
     * @param $messages
     * @return \Illuminate\Support\MessageBag
     */
    protected static function toMessageBag($messages)
    {
        if(is_array($messages))
        {
            return new MessageBag($messages);
        }

        if(is_string($messages))
        {
            return new MessageBag(array($messages));
        }

        return $messages;
    }
}