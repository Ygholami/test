<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User_wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{

    public function addMoney(Request $request)
    {
        $referenceId = mt_rand(10000000, 99999999);
        $addMoney = User_wallet::create(['type' => 'credit',
            'amount' => $request->amount,
            'reference_id' => $referenceId,
            'user_id' => $request->user_id,
            'status' => $request->status ? $request->user_id : 1,
        ]);
        return response()->json([
            'user_id' => $addMoney->user_id,
            'amount' => $addMoney->amount,
            'Output:' => ['reference_id' => $addMoney->reference_id]
        ]);
    }

    public function getBalance($user_id)
    {
        $credit = DB::table('users as u')
            ->join('User_wallets as uw', 'uw.user_id', '=', 'u.id')
            ->where('uw.user_id','=',$user_id)
            ->where('uw.type', 'credit')->sum('uw.amount');


        $debit = DB::table('users as u')
            ->join('User_wallets as uw', 'uw.user_id', '=', 'u.id')
            ->where('uw.user_id','=',$user_id)
            ->where('uw.type', 'debit')->sum('uw.amount');

        $balance = $credit - $debit;

        return response()->json([
            'user_id' => $user_id,
            'Output:' => ["balance"=>$balance]
        ]);
    }
}
