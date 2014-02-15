<?php

class DateRangeModel extends BaseModel {

    /**
     * @return mixed|void
     */
    public function beforeSave()
    {
        if($this->from_date == '')
        {
            $this->attributes['from_date'] = '2000-01-01 01:01:01';
        }

        if($this->to_date == '')
        {
            $this->attributes['to_date'] = '2060-01-01 01:01:01';
        }
    }

    /**
     * @return mixed|void
     */
    public function makeInfinite()
    {
        $this->attributes['from_date'] = '2000-01-01 01:01:01';
        $this->attributes['to_date'] = '2060-01-01 01:01:01';
    }

    /**
     * @param $value
     */
    public function setFromDateAttribute($value)
    {
        if($value instanceof \DateTime)
        {
            $this->attributes['from_date'] = $value->format('Y-m-d H:i:s');
        }
        else
        {
            $this->attributes['from_date'] = date('Y-m-d H:i:s', strtotime($value));
        }
    }

    /**
     * @param $value
     */
    public function setToDateAttribute($value)
    {
        if($value instanceof \DateTime)
        {
            $this->attributes['to_date'] = $value->format('Y-m-d H:i:s');
        }
        else
        {
            $this->attributes['to_date'] = date('Y-m-d H:i:s', strtotime($value));
        }
    }

    /**
     * @param $query
     * @param $date
     * @return mixed
     */
    public function scopeCurrent($query, $date)
    {
        if($date instanceof \DateTime) $date = $date->format('Y-m-d H:i:s');

        return $query->where('from_date', '<=', $date)->where('to_date', '>=', $date);
    }
}