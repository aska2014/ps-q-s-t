<?php namespace Messages;

use Kareem3d\Membership\UserInfo;

class Contact extends \BaseModel {

    /**
     * @var string
     */
    protected $table = 'contact_messages';

    /**
     * @var array
     */
    protected $rules = array(
        'subject' => 'required',
        'body' => 'required'
    );

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userInfo()
    {
        return $this->belongsTo(UserInfo::getClass());
    }
}