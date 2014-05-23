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
     * @var array
     */
    protected $with = array('transaction');

    /**
     * @param $query
     * @param $uniqueIdentifier
     * @return mixed
     */
    public function scopeByUniqueIdentifier($query, $uniqueIdentifier)
    {
        return $query->join('orders', 'orders.id', '=', 'migs_payments.order_id')
                    ->where('orders.unique_identifier', $uniqueIdentifier)
                    ->select('migs_payments.*');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::getClass());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function transaction()
    {
        return $this->hasOne(MigsTransaction::getClass(), 'payment_id');
    }
}