<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use App\DetailTransaction;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Product;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    //

    public function index(){
        $user = User::find(Auth::id());
        $userTransactions = $user->allTransaction();
        return response()->json(['data' => $transactions, 'status' => 1]);
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


        // return 'sebelumcek';
        if ($user->point < $product->point){
            return response()->json(['status'=> 0 , "message"=> 'Point Tidak Mencukupi']);
        }
        
        return 'setelah cek';

        $transaction = new Transaction();        
        $transaction->user_id = Auth::id();
        $transaction->save();

            $detail_transaction = new DetailTransaction();
            $detail_transaction->transaction_id = $transaction->id;
            $detail_transaction->product_id = $product_id;
            $detail_transaction->save();
        
        // foreach ($request->product_id as $product_id){
        //     $detail_transaction = new DetailTransaction();
        //     $detail_transaction->transaction_id = $transaction->id;
        //     $detail_transaction->product_id = $product_id;
        //     $detail_transaction->save();
        // }

        // return response()->json(['data'=>$transaction->detailTransaction, 'data3'=>$transaction, 'status'=> 1]);
        return response()->json(['data3'=>$transaction, 'status'=> 1]);

    }
}
