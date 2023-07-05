<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    public const STARTED = 'started';
    public const PENDING = 'pending';
    public const NOT_STARTED = 'not_started';
    

    protected $fillable = ["title", "todo_list_id", "status"];

    public function todo_list(): BelongsTo {

        return $this->belongsTo(TodoList::class);
    }
}
