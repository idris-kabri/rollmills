<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

class InteractionController extends Controller
{
    public function store($platform, Request $request)
    {
        $data = $request->all();
        Log::error('Insta Store: ');
        Log::error($request->all());

        $response = Http::post("https://graph.facebook.com/v21.0/18165448510388010/replies", [
            'message' => "Thanks for your comment! Here's the link you requested 😊",
            'access_token' => "IGAAWMVmPvKlpBZAFRnci1iemlhanlPUDNIMjBDLVNHVDR2V1B1cW8yYVZARengwY1dHTHF6a1g1TldBSUtlVFBQWHVoZAEVyUVlKblhSa2VVLXM2V21kVjdrTWxfNkpYVEZAYLTBzUjB4MU9kYThOQ0NoUjBhSmJwT3lMRnQ4U2UyTQZDZD",
        ]);

        Log::error($response->json());

        return response()->json([
            'data' => $data,
            'platform' => $platform,
            'status' => 200,
            'message' => 'Data store successfully',
        ]);
    }

    public function verify($platform, Request $request)
    {
        Log::error('Insta Verify: ');
        Log::error($request->all());
        $data = $request->all();

        $hub_challenge = $data['hub_challenge'] ?? '';

        return $hub_challenge;
    }
}
