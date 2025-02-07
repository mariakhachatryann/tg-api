<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Attributes as OAA;


#[OAA\Schema(
    schema: 'Message',
    type: 'object',
    description: 'Message object'
)]
class Message extends Model
{
    use HasFactory;
    #[OAA\Property(type: 'integer', description: 'ID')]
    public int $id;

    #[OAA\Property(type: 'integer', description: 'The chat ID')]
    public int $chat_id;

    #[OAA\Property(type: 'integer', description: 'The message ID')]
    public int $message_id;

    #[OAA\Property(type: 'string', description: 'The message content')]
    public string $message;

    #[OAA\Property(type: 'integer', description: 'The message date')]
    public int $date;

    protected $guarded = [];
    public $timestamps = true;
//    public function getDateFormat()
//    {
//        return 'U';
//    }
}
