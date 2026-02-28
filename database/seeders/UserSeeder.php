<?php

namespace Database\Seeders;

use App\Models\Phone;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!User::query()->where('email', 'admin@mail.ru')->exists()) {
            User::query()->create([
                'name' => 'Admin',
                'email' => 'admin@mail.ru',
                'password' => Hash::make('password'),
                'slug' => Str::slug('admin'),
                'role_id' => Role::query()->where('slug', 'admin')->firstOrFail()->id,
            ]);
        }
        User::factory([
            'role_id' => Role::query()->where('slug', 'user')->firstOrFail()->id,
        ])
            ->has(Phone::factory()->count(3), 'phones')
            ->count(100)
            ->create();
    }
}
