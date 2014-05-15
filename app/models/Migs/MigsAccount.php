<?php namespace Migs;

use BaseModel;
use Illuminate\Support\Facades\Crypt;

class MigsAccount extends BaseModel {

    /**
     * @var string
     */
    protected $table = 'migs_accounts';

    /**
     * @var array
     */
    protected $fillable = array('access_code', 'secret', 'merchant_id', 'name');

    /**
     * @var array
     */
    protected $hidden = array('secret');

    /**
     * @param $query
     * @param $name
     * @return mixed
     */
    public function scopeByName($query, $name)
    {
        return $query->where('name', $name);
    }

    /**
     * @param $value
     */
    public function setMerchantIdAttribute($value)
    {
        $this->attributes['merchant_id'] = Crypt::encrypt($value);
    }

    /**
     * @param $value
     */
    public function setAccessCodeAttribute($value)
    {
        $this->attributes['access_code'] = Crypt::encrypt($value);
    }

    /**
     * @param $value
     */
    public function setSecretAttribute($value)
    {
        $this->attributes['secret'] = Crypt::encrypt($value);
    }

    /**
     * @param $value
     * @return mixed
     */
    public function getMerchantIdAttribute($value)
    {
        return Crypt::decrypt($value);
    }

    /**
     * @param $value
     */
    public function getSecretAttribute($value)
    {
        return Crypt::decrypt($value);
    }

    /**
     * @param $value
     */
    public function getAccessCodeAttribute($value)
    {
        return Crypt::decrypt($value);
    }
}