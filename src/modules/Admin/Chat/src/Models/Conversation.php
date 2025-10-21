<?php

namespace Modules\Admin\Chat\src\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Chat\factories\ConversationFactory;

class Conversation extends Model
{
    use HasFactory;

    protected $table = 'conversations';

    protected $fillable = [
        'user_id', 'employee_id'
    ];

    protected static function newFactory()
    {
        return ConversationFactory::new();
    }
}
