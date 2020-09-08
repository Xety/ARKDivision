<?php
namespace Xetaravel\Models;

use Xetaravel\Models\Presenters\PaypalUserPresenter;

class PaypalUser extends Model
{
    use PaypalUserPresenter;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'paypal_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'email',
        'first_name',
        'last_name',
        'payer_id',
        'country_code',
        'amount_total'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'full_name',
    ];

    /**
     * Get the user for the paypal.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the transactions for the paypal.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany(TransactionUser::class, 'paypal_id', 'id');
    }
}
