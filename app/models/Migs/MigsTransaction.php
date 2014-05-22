<?php namespace Migs;

use Kareem3d\Eloquent\Model;

class MigsTransaction extends Model {

    /**
     * @var string
     */
    protected $table = 'migs_transactions';

    /**
     * @var array
     */
    protected $fillable = array('vpc_Amount', 'vpc_Currency', 'vpc_AuthorizeId', 'vpc_BatchNo',
                                'vpc_Card', 'vpc_CardNum', 'vpc_ReceiptNo', 'vpc_TransactionNo');

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payment()
    {
        return $this->belongsTo(MigsPayment::getClass());
    }
}