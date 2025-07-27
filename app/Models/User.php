<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany; // Import HasMany
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar_url',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public static function booted()
    {
        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

    public function todoLists(): HasMany
    {
        return $this->hasMany(TodoList::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    public function getAvatarHtmlAttribute(): string
    {
        $commonClasses = 'rounded-full object-cover';
        $sizeClasses = 'h-8 w-8';

        if ($this->avatar_url) {
            return '<img src="' . asset($this->avatar_url) . '" alt="' . $this->name . '\'s avatar" class="' . $commonClasses . ' ' . $sizeClasses . '">';
        }

        return '<span class="flex items-center justify-center ' . $commonClasses . ' ' . $sizeClasses . ' bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">' . $this->initials() . '</span>';
    }

    public function avatar(): ?string
    {
        return $this->avatar_url ?: null;
    }
}