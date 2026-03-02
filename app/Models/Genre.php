<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $id
 * @property string $value
 * @property string $label
 */
class Genre extends Model
{
    use HasUuids, SoftDeletes;
    public $timestamps = false;

    protected $fillable = [
        'value',
        'label'
    ];

    public function musics(): HasMany
    {
        return $this->hasMany(Music::class);
    }
}
