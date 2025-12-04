<?php

namespace App\Http\Controllers;

use App\Models\InteractionPlatform;
use App\Models\PostPlatform;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

class InteractionController extends Controller
{
    public function store($platform, Request $request)
    {
        $data = $request->all();
        $entry = $data['entry'][0] ?? null;

        if ($entry && isset($entry['changes'][0]) && ($entry['changes'][0]['field'] ?? null) === 'comments') {

            Log::error('Insta Store: ');
            Log::error($request->all());

            $change = $entry['changes'][0];
            $value  = $change['value'];

            $user_id    = $value['from']['id'];
            $user_name  = $value['from']['username'];
            $post_id    = $value['media']['id']; 
            $description = $value['text'];
            $comment_id  = $value['id']; 

            $store = new InteractionPlatform();
            $store->user_id = $user_id;
            $store->name = $user_name;
            $store->type = "Comment";
            $store->post_id = $post_id;
            $store->description = $description;
            $store->save();

            $lowercase_desc = strtolower($description);

            $match = PostPlatform::whereRaw("LOWER(keyword) LIKE ?", ["%{$lowercase_desc}%"])
                ->first();

            $post_message = Setting::where("label", "post_comment_message")->value('value') ?? '';

            $response = Http::post("https://graph.facebook.com/v21.0/$comment_id/replies", [
                'message' => $post_message,
                'access_token' => config('instagram.access_token'),
            ]);

            Log::error($response->json());

            return response()->json([
                'data' => $data,
                'platform' => $platform,
                'status' => 200,
                'message' => 'Data stored successfully',
            ]);
        }
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
