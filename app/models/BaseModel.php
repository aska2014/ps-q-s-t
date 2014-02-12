<?php

class BaseModel extends \Kareem3d\Eloquent\Model {

    /**
     * @param $query
     * @return mixed
     */
    public function scopeRandom($query)
    {
        return $query->orderBy(DB::raw('RAND()'));
    }

}