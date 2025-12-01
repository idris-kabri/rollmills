<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InteractionController extends Controller
{
    public function store($platform, Request $request)
    {
        $data = $request->all();
        return response()->json([
            'data' => $data,
            'platform' => $platform,
            'status' => 200,
            "message" => "Data store successfully"
        ]);
    }
}
