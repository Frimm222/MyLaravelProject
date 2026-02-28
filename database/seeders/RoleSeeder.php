<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'label' => 'Админ',
                'slug' => 'admin',
            ],
            [
                'label' => 'Пользователь',
                'slug' => 'user',
            ]
        ];
        foreach ($roles as $role) {
            Role::query()->firstOrCreate([
                'label' => $role['label'],
            ], $role);
        }
    }
}
