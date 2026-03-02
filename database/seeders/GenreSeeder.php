<?php

namespace Database\Seeders;

use App\Models\Genre;
use App\MusicGenre;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genres = MusicGenre::options();

        foreach ($genres as $genre) {
            Genre::query()->firstOrCreate(
                [
                    'value' => $genre['value']
                ],
                [
                    'value' => $genre['value'],
                    'label' => $genre['label']
                ]
            );
        }
    }
}
