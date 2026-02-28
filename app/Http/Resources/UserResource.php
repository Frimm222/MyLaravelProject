<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'age' => $this->age,
            'created_at' => $this->created_at,
            'slug' => $this->slug,
            'active' => $this->active === 1 ? 'Active' : 'Inactive',
            'phones' => $this->phones,
            'avatar' => $this->avatar
        ];
    }
}
