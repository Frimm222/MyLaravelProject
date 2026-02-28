<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Phone extends Model
{
    use HasFactory;

   protected $fillable = [
        'user_id',
        'number',
       'phone_brand_id'
    ];

    public function user()
    {
        return $this->belongTo(User::class);
    }

    public function phoneBrand(): belongsTo
    {
        return $this->belongsTo(PhoneBrand::class);
    }
}
