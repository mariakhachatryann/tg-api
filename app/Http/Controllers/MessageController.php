<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Services\TelegramBotService;
use Illuminate\Http\Request;
use OpenApi\Attributes as OAA;

#[\OpenApi\Attributes\Info(
    title: "Telegram Messaging API",
    version: "latest",
    description: "API for managing messages between users and guests via a Telegram bot. This API allows to receive messages from users, store them, and send replies through the Telegram bot",
)]

class MessageController extends Controller
{
    protected $telegramService;

    public function __construct(TelegramBotService $telegramService)
    {
        $this->telegramService = $telegramService;
    }
    #[OAA\Get(
        path: "/messages",
        summary: "Get all messages",
        description: "Retrieve all the messages from the system, optionally filtered by chat_id",
        parameters: [
            new OAA\Parameter(
                name: "chat_id",
                in: "query",
                description: "Filter messages by chat_id",
                required: false,
                schema: new OAA\Schema(type: "string")
            )
        ],
        responses: [
            new OAA\Response(
                response: 200,
                description: "A list of messages",
                content: new OAA\JsonContent(type: "array", items: new OAA\Items(ref: "#/components/schemas/Message"))
            )
        ]
    )]
    public function getMessages(Request $request)
    {
        $chatId = $request->query('chat_id');
        if ($chatId) {
            $messages = Message::where('chat_id', $chatId)->get();
        } else {
            $messages = Message::all();
        }
        return response()->json($messages);
    }

    #[OAA\Post(
        path: "/messages/reply",
        summary: "Send a reply to a message",
        description: "Send a reply to a message from a user via the Telegram bot",
        requestBody: new OAA\RequestBody(
            description: "The message data required to send a reply",
            required: true,
            content: new OAA\JsonContent(
                type: "object",
                properties: [
                    new OAA\Property(
                        property: "chat_id",
                        type: "integer",
                        description: "The chat ID to reply to"
                    ),
                    new OAA\Property(
                        property: "message",
                        type: "string",
                        description: "The message content to send"
                    )
                ]
            )
        ),
        responses: [
            new OAA\Response(
                response: 200,
                description: "Successfully sent the reply",
                content: new OAA\JsonContent(
                    type: "object",
                    properties: [
                        new OAA\Property(
                            property: "ok",
                            type: "boolean",
                            description: "Indicates if the message was successfully sent"
                        ),
                        new OAA\Property(
                            property: "result",
                            type: "object",
                            description: "The result object containing the details of the sent message"
                        )
                    ]
                )
            ),
        ]
    )]
    public function sendReply(Request $request)
    {
        try {
            $data = $request->validate([
                'chat_id' => 'required',
                'message' => 'required',
            ]);

            $response = $this->telegramService->sendMessage($data['chat_id'], $data['message']);
            return response()->json($response);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => 'Validation failed', 'details' => $e->errors()], 422);
        }
    }

}
