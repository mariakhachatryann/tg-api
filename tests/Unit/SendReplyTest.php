<?php

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use App\Services\TelegramBotService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SendReplyTest extends TestCase
{
    use RefreshDatabase;

    private $telegramService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->telegramService = Mockery::mock(TelegramBotService::class);
        $this->app->instance(TelegramBotService::class, $this->telegramService);
    }

    #[Test]
    public function it_sends_a_reply_successfully()
    {
        $payload = [
            'chat_id' => '123456',
            'message' => 'Hello, this is a test reply!',
        ];

        $mockResponse = [
            'ok' => true,
            'result' => [
                'message_id' => '98765',
                'chat' => ['id' => '123456'],
                'text' => 'Hello, this is a test reply!',
            ],
        ];

        $this->telegramService
            ->shouldReceive('sendMessage')
            ->once()
            ->with($payload['chat_id'], $payload['message'])
            ->andReturn($mockResponse);

        $response = $this->postJson('/send-message', $payload);

        $response->assertStatus(200)
            ->assertJson($mockResponse);
    }

    #[Test]
    public function it_returns_error_when_sending_fails()
    {
        $payload = [
            'chat_id' => '123456',
            'message' => 'Hello, this is a test reply!',
        ];

        $this->telegramService
            ->shouldReceive('sendMessage')
            ->once()
            ->with($payload['chat_id'], $payload['message'])
            ->andThrow(new \Exception('Telegram API error'));

        // Send request
        $response = $this->postJson('/send-message', $payload);

        // Assert failure response
        $response->assertStatus(500)
            ->assertJson(['message' => 'Telegram API error']);
    }
}
