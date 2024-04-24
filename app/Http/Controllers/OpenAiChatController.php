<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;  //for calling api
use Illuminate\Http\JsonResponse;

class OpenAiChatController extends Controller
{
    //
    public function openAiChat() :JsonResponse
    {
        $search = "what is google";
        $data = Http::WithHeaders([
            "Content-Type" => 'application/json',
            "Authorization" => 'Bearer'.env('OPEN_API_KEY'),
        ])->post('https://api.openai.com/v1/completions',[
            'model' => 'gpt-3.5-turbo-instruct',
            'messages' => [
            [
                'role' => 'user',
                'content' => $search
            ]
                ],
                'temperature' => 0.5,
                'max_tokens'  => 200,
                'top_p' => 1.0,
                'frequency_penalty' => 0.52,
                'presence_penalty' => 0.5,
                'stop' => ["11."]

        ])
        ;
    }
}
