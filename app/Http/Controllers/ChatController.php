<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Events\MessageCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function index()
    {
        return Message::all();
    }

    public function store(Request $request)
    {
        // return Message::create($request->all());
        Log::debug($request);
        $message = Message::create([
            'body' => $request->body
        ]);
        event(new MessageCreated($message));
    }

    public function destroy(Message $id)
    {
        $id->delete();
    
        return $id;
    }

    // public function create(Request $request) {

    //     $message = App\Models\Message::create([
    //         'body' => $request->message
    //     ]);
    //     event(new MessageCreated($message));
    // }
}
