<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use App\DetailTransaction;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class TransactionController extends Controller
{
    //

    public function index(){
        $user = User::find(Auth::id());
        // $userTransactions = $user->allTransaction();
        $userTransactions = DB::table('users')
            ->join('transactions', 'users.id', '=', 'transactions.user_id')
            ->join('products', 'transactions.product_id', '=', 'products.id')
            ->select('products.*')
            ->get();

        return response()->json(['data' => $userTransactions, 'status' => 1]);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|integer',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors'=> $validator->errors(), 'status' => 0]);
        }

        $product = Product::find($request->product_id);
        $userId = Auth::id();
        $user = User::find($userId);


        if ($user->point < $product->point){
            return response()->json(['status'=> 0 , "message"=> 'Point Tidak Mencukupi']);
        }
        
        $user->point -= $product->point;
        $user->save();

        $transaction = new Transaction();        
        $transaction->user_id = Auth::id();
        $transaction->product_id = $request->product_id;
        $transaction->save();


        // return $data_transaction;

        return response()->json(['data'=>$transaction, 'status'=> 1]);

    }
}
