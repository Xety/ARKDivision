<?php
namespace Xetaravel\Models\Repositories;

use Xetaravel\Models\TransactionUser;

class TransactionUserRepository
{
    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data The data used to create the user.
     *
     * @return \Xetaravel\Models\TransactionUser
     */
    public static function create(array $data): TransactionUser
    {
        return TransactionUser::create([
            'user_id' => $data['user_id'],
            'paypal_id' => $data['paypal_id'],
            'payment_id' => $data['payment_id'],
            'amount' => $data['amount'],
            'currency' => $data['currency'],
            'custom' => $data['custom']
        ]);
    }
}
