<?php
namespace Xetaravel\Models\Repositories;

use Xetaravel\Models\PaypalUser;

class PaypalUserRepository
{
    /**
     *  Get or create the Paypal related to the user.
     *
     * @param array $data The data used to create the paypal.
     *
     * @return \Xetaravel\Models\PaypalUser
     */
    public static function getOrCreate(array $data): PaypalUser
    {
        return PaypalUser::firstOrCreate(
            [
                'user_id' => $data['user_id']
            ],
            [
                'user_id' => $data['user_id'],
                'email' => $data['email'],
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'payer_id' => $data['payer_id'],
                'country_code' => $data['country_code']
            ]
        );
    }
}
