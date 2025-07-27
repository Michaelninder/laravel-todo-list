<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TodoItem extends Model
{
    /** @use HasFactory<\Database\Factories\TodoItemFactory> */
    use HasFactory;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'list_id',
        'name',
        'state',
    ]
    /**
     * Get the user that owns the TodoItem
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(TodoList::class, 'list_id', 'id');
    }

    public static function booted() {
        static::creating(function ($this) {
            $this->id = Str::uuid();
        });
    }
}
