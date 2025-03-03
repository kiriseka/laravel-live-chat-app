<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Services\GeminiService;

class ChatController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function broadcast(Request $request)
    {
        $message = $request->input('message');
        broadcast(new MessageSent($message))->toOthers();
        return view('broadcast', [
            'message' => $request->get('message'),
        ]);
    }

    public function receive(Request $request)
    {
        $message = $request->input('message');
        return view('receive', [
            'message' => $message,
        ]);
    }

}