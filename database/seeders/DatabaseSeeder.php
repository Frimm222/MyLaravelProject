<?php

namespace Database\Seeders;

use App\Models\PhoneBrand;
use App\Models\Role;
use App\Models\User;
use App\Models\Phone;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            PhoneBrandSeeder::class,
            UserSeeder::class,
            MusicSeeder::class,
        ]);
    }
}
