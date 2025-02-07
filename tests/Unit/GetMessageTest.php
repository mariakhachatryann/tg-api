<?php

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Message;

class GetMessageTest extends TestCase
{
    use RefreshDatabase;

    #[Test] public function it_returns_all_messages_when_no_chat_id_is_provided()
    {
        Message::factory()->count(3)->create();
        $response = $this->getJson('/messages');
        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    #[Test] public function it_returns_filtered_messages_when_chat_id_is_provided()
    {
        $chatId = 123;
        Message::factory()->count(2)->create(['chat_id' => $chatId]);
        Message::factory()->count(3)->create(['chat_id' => 456]);
        $response = $this->getJson("/messages?chat_id={$chatId}");
        $response->assertStatus(200)
            ->assertJsonCount(2)
            ->assertJsonFragment(['chat_id' => $chatId]);
    }
}
