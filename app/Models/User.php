<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $keyType = 'string';
    public $incrementing = false;

    public static function booted()
    {
        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }
    
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar_url',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    /**
     * Get the HTML for the user's avatar, with a fallback to initials.
     *
     * @return string
     */
    public function getAvatarHtmlAttribute(): string
    {
        $commonClasses = 'rounded-full object-cover';
        $sizeClasses = 'h-8 w-8';

        if ($this->avatar_url) {
            return '<img src="' . asset($this->avatar_url) . '" alt="' . $this->name . '\'s avatar" class="' . $commonClasses . ' ' . $sizeClasses . '">';
        }

        return '<span class="flex items-center justify-center ' . $commonClasses . ' ' . $sizeClasses . ' bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">' . $this->initials() . '</span>';
    }

    /**
     * Helper to get the raw avatar URL or null.
     */
    public function avatar(): ?string
    {
        return $this->avatar_url ?: null;
    }
}