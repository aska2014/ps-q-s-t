<?php namespace Migs;

use ECommerce\Order;
use Kareem3d\Eloquent\Model;

class MigsPayment extends Model {

    /**
     * Payment status
     */
    const PENDING = 'pending';
    const CANCELED = 'canceled';
    const ACCEPTED = 'accepted';


    /**
     * @var string
     */
    protected $table = 'migs_payments';

    /**
     * @var array
     */
    protected $fillable = array('currency', 'amount', 'status', 'order_id');

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::getClass());
    }
}