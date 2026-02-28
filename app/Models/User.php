<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\Filters;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

/**
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $slug
 * @property integer $id
 * @property integer $age
 * @property boolean $active
 * @property integer $role_id
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, Filters;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'active',
        'age',
        'slug',
        'role_id',
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

      public function phones()
    {
        return $this->hasMany(Phone::class);
    }

    public function avatar(): HasOne
    {
        return $this->hasOne(Avatar::class);
    }

    //Акцессор
//    public function getNameAttribute(): string
//    {
//        return Str::upper($this->attributes['name']);
//    }

//    public function setSlugAttribute(string $name): void
//    {
//        $this->attributes['name'] = Str::upper($name);
//    }

    public function musics(): BelongsToMany
    {
        return $this->belongsToMany(Music::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', true);
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function isAdmin(): bool
    {
        return $this->role->slug === 'admin';
    }

    public function isUser(): bool
    {
        return $this->role->slug === 'user';
    }
}
