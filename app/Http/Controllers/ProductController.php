<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ProductController extends Controller
{
    public function index(){
        $products = Product::all();
        return response()->json(['data'=> $products, 'status' => 1]);
    }

    public function store(Request $request){
        
        $validator = Validator::make($request->all(), [
            'nama_barang' => 'required|string',
            'harga' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=> $validator->errors(), 'status' => 0]);
        }

        $product= new Product();
        $product->nama_barang = $request->nama_barang;
        $product->harga = $request->harga;
        $product->save();
        
        return response()->json(['data' => $product, 'status' => $status]);

    }
    
}
