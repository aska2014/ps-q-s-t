<?php namespace Offers;

use ECommerce\Product;

class OfferPosition extends \BaseModel {

    /**
     * @var string
     */
    protected $table = 'offer_positions';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(){ return $this->belongsTo(Product::getClass()); }
}