<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $comment
 * @property int $user_id
 */
class Comment extends Model
{
    use SoftDeletes, HasFactory;
    protected $fillable = [
        'comment',
        'user_id'
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public $timestamps = false;

    public function musics(): MorphToMany
    {
        return $this->morphedByMany(Music::class, 'commentgable');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
