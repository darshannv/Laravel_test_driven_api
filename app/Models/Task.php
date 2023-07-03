<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ["title", "todo_list_id"];

    public function todo_list(): BelongsTo {

        return $this->belongsTo(TodoList::class);
    }
}
