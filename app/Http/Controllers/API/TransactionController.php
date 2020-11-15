<?php

namespace Xetaravel\Http\Controllers\API;

use Illuminate\Http\Request;
use Xetaravel\Http\Resources\Json;
use Xetaravel\Models\TransactionUser;

class TransactionController extends Controller
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
        $transactions = TransactionUser::where('user_id', $id)->get();

        return new Json($transactions);
    }
}
