<?php
namespace Xetaravel\Models;

use Eloquence\Behaviours\CountCache\Countable;
use Eloquence\Behaviours\SumCache\Summable;

class TransactionUser extends Model
{
    use Countable,
    Summable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'transaction_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'paypal_id',
        'payment_id',
        'amount',
        'currency',
        'custom'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'custom' => 'array'
    ];

    /**
     * Return the count cache configuration.
     *
     * @return array
     */
    public function countCaches(): array
    {
        return [
            'transaction_count' => [User::class, 'user_id', 'id']
        ];
    }

    /**
     * Return the sum cache configuration.
     *
     * @return array
     */
    public function sumCaches(): array
    {
        return [
            'amount_total' => [PaypalUser::class, 'amount', 'paypal_id', 'id']
        ];
    }

    /**
     * Get the paypal that owns the transaction.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paypal()
    {
        return $this->belongsTo(PaypalUser::class);
    }

    /**
     * Get the user that owns the transaction.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
