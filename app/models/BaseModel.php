<?php

class BaseModel extends \Kareem3d\Eloquent\Model {

    /**
     * @param $attribute
     * @return string
     */
    public function getClean($attribute)
    {
        return addslashes($this->getAttribute($attribute));
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeRandom($query)
    {
        return $query->orderBy(DB::raw('RAND()'));
    }
}