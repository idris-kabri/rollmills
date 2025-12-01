<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InteractionController extends Controller
{
    public function store($platform, Request $request)
    {
        $data = $request->all();
        Log::error("Insta Store: ");
        Log::error($request->all());
        return response()->json([
            'data' => $data,
            'platform' => $platform,
            'status' => 200,
            "message" => "Data store successfully"
        ]);
    }

    public function verify($platform, Request $request)
    {
        Log::error("Insta Verify: ");
        Log::error($request->all());
        $data = $request->all();

        $hub_challenge = $data['hub_challenge'] ?? '';

        return $hub_challenge;
    }
}
