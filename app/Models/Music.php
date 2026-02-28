<?php

namespace App\Models;

use App\MusicGenre;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property string $title
 * @property string $artists
 * @property string $file_path
 * @property string $cover_path
 * @property integer $duration
 * @property Carbon $release_date
 * @property boolean $is_published
 * @property integer $plays
 * @property string $genre
 */
class Music extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'artists',
        'file_path',
        'cover_path',
        'duration',
        'release_date',
        'is_published',
        'plays',
        'genre'
    ];

    protected $casts = [
        'artists' => 'array'
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function isFavoritedBy(?User $user): bool
    {
        if (!$user) return false;
        return $this->users()->where('user_id', $user->id)->exists();
    }

    public function setArtistsAttribute(mixed $artists): void
    {
        if (is_string($artists)) {
            $this->attributes['artists'] = json_encode(explode(',', $artists));
        }
    }
}
