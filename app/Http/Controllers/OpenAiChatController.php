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
    }
}
