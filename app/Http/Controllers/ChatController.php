<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Services\AIService;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $messages = $request->session()->get('messages', []); // Get messages from session
        return view('chat', ['messages' => $messages]);
    }

    public function setUsername(Request $request)
    {
        $request->session()->put('username', $request->input('username'));
        return redirect()->route('chat.index');
    }

    public function sendMessage(Request $request)
    {
        $message = $request->input('message');
        $aiService = new AIService();
        $response = $aiService->generateResponse($message);

        if (!isset($response['choices'][0]['message']['content'])) {
            $responseContent = 'Error: Unable to generate response.';
        } else {
            $responseContent = $response['choices'][0]['message']['content'];
        }

        $messages = $request->session()->get('messages', []);
        $messages[] = ['role' => 'user', 'content' => $message];
        $messages[] = ['role' => 'assistant', 'content' => $responseContent];
        $request->session()->put('messages', $messages);

        return redirect()->route('chat.index');
    }

    public function getNewMessages(Request $request)
    {
        $lastMessageId = $request->input('last_message_id');
        $newMessages = Message::where('id', '>', $lastMessageId)->get();
        $lastMessageId = $newMessages->last()->id ?? $lastMessageId;
        return response()->json([
            'messages' => $newMessages,
            'last_message_id' => $lastMessageId
        ]);
    }
}
