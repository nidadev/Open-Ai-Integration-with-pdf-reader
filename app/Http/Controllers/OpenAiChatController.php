<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;  //for calling api
use Illuminate\Http\JsonResponse;
use LucianoTonet\Groq;

class OpenAiChatController extends Controller
{
    //
    public function openApiChat() :JsonResponse
    {
        $search = "what is pm";
        $data = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.env('GROQ_API_KEY'),
            
        ])->post('https://api.groq.com/openai/v1/chat/completions',[
            'messages' => [
            [
                'role' => 'user',
                'content' => $search
            ]
                ],
                'model' => 'mixtral-8x7b-32768',

                'temperature' => 0.5,
                'max_tokens'  => 200,
                'top_p' => 1.0,
                'frequency_penalty' => 0.52,
                'presence_penalty' => 0.5,
                'stop' => ["11."]
                ])->json();
                //dd($data);

        return response()->json($data["choices"][0]['message'], 200,array(),JSON_PRETTY_PRINT);
        /*$groq = new Groq(getenv('GROQ_API_KEY'));

$chatCompletion = $groq->chat()->completions()->create([
  'model'    => 'mixtral-8x7b-32768',
  'messages' => [
    [
      'role'    => 'user',
      'content' => 'Explain the importance of low latency LLMs'
    ],
  ]
]);

echo $chatCompletion['choices'][0]['message']['content'];*/
    }
}
