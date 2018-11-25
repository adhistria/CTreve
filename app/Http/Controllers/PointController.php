<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Point;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PointController extends Controller
{

    public function store(Request $request)
    {
        $point = new Point();

        $validator = Validator::make($request->all(), [
            'point' => 'required|integer',
            'user_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=> $validator->errors(), 'status' => 0]);
        }

        $point->point = $request->point;
        $point->user_id = $request->user_id;
        $point->admin_id = Auth::id();
        $point->save();
        return response()->json(['data'=> $point, 'status'=>1]);
    }

}
