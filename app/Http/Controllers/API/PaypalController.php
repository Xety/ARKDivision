<?php

namespace Xetaravel\Http\Controllers\API;

use Illuminate\Http\Request;
use Xetaravel\Http\Resources\Json;
use Xetaravel\Models\PaypalUser;

class PaypalController extends Controller
{
    /**
     *  Get a paypal by a user id.
     *
     * @param int $id The user id.
     *
     * @return \Xetaravel\Http\Resources\Json
     */
    public function getByUser(int $id)
    {
        $paypal = PaypalUser::where('user_id', $id)->first();

        return new Json($paypal);
    }
}
