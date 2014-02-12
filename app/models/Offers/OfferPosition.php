<?php namespace Offers;

use ECommerce\Product;
use Illuminate\Database\Eloquent\Collection;

class OfferPosition extends \DateRangeModel {

    /**
     * @var string
     */
    protected $table = 'offer_positions';

    /**
     * @var array
     */
    protected static $availablePositions = array(
        'left_offer',
        'right_offer'
    );

    /**
     * @var array
     */
    protected $with = array('product');

    /**
     * @var array
     */
    protected $fillable = array('title', 'from_date', 'to_date', 'position', 'product_id');


    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @param $query
     * @return mixed
     */
    public function scopeAllPositions($query)
    {
        foreach(static::$availablePositions as $position)
        {
            $query->where('position', $position);
        }

        return $query;
    }

    /**
     * @param $query
     * @param $position
     * @return mixed
     */
    public function scopeByPosition($query, $position)
    {
        return $query->where('position', $position);
    }

    /**
     * @return Collection
     */
    public static function getAllActive()
    {
        $collection = new Collection();

        foreach(static::$availablePositions as $position)
        {
            $offerPosition = static::byPosition($position)->current(new \DateTime())->first();

            $offerPosition = $offerPosition ?: new static(compact('position'));

            $collection->add($offerPosition);
        }

        return $collection;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(){ return $this->belongsTo(Product::getClass()); }
}