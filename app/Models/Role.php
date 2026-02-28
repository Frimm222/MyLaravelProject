<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $label
 * @property string $slug
 */
class Role extends Model
{
    protected $fillable = [
      'label',
      'slug',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
