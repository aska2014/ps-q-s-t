<?php namespace Location;


class Country extends \BaseModel {

    /**
     * @var string
     */
    protected $table = 'countries';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * Defining relations
     */
    public function cities(){return $this->hasMany(City::getClass());}

}