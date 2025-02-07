<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class TelegramController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $update = $request->all();
        if (empty($update['message'])) {
            return response()->json([
                'status' => 'ignored',
                'message' => 'No updates found'
            ]);
        }

        $chatId = $update['message']['chat']['id'] ?? null;
        $messageText = $update['message']['text'] ?? null;
        $messageId = $update['message']['message_id'] ?? null;
        $userId = $update['message']['from']['id'] ?? null;
        $messageDate = $update['message']['date'] ?? null;

        if (!$chatId || !$messageText || !$messageId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid message data'
            ], 400);
        }

        try {
            if (Message::where('message_id', $messageId)->exists()) {
                return response()->json([
                    'status' => 'ignored',
                    'message' => 'Message already processed'
                ]);
            }

            Message::create([
                'chat_id' => $chatId,
                'message_id' => $messageId,
                'message' => $messageText,
                'date' => $messageDate,
                'user_id' => $userId,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Message saved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to save message',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
