<?php

namespace Database\Seeders;

use App\Models\Music;
use App\Models\User;
use App\MusicGenre;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class MusicSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::query()->where('email', 'admin@mail.ru')->firstOrFail();

        $musics = [
            [
                'title' => '18 Мне Уже',
                'artists' => [
                    'Сергей Жуков'
                ],
                'file_path' => 'public/music_files/Руки Вверх - 18 Мне Уже.mp3',
                'cover_path' => 'public/music_files/ruki-vverh.jpg',
                'duration' => 247,
                'release_date' => Carbon::now()->toDateTimeString(),
                'is_published' => true,
                'plays' => 0,
                'genre' => MusicGenre::POP,
            ],
            [
                'title' => 'Руки Вверх - Он Тебя Целует',
                'artists' => [
                    'Сергей Жуков'
                ],
                'file_path' => 'public/music_files/Руки Вверх - Он Тебя Целует.mp3',
                'cover_path' => 'public/music_files/ruki-vverh.jpg',
                'duration' => 243,
                'release_date' => Carbon::now()->toDateTimeString(),
                'is_published' => true,
                'plays' => 0,
                'genre' => MusicGenre::POP,
            ],
            [
                'title' => 'Группа крови',
                'artists' => [
                    'Виктор Цой'
                ],
                'file_path' => 'public/music_files/Виктор Цой - Группа крови.mp3',
                'cover_path' => 'public/music_files/viktor-tsoj.jpg',
                'duration' => 240,
                'release_date' => Carbon::now()->toDateTimeString(),
                'is_published' => true,
                'plays' => 0,
                'genre' => MusicGenre::ROCK,
            ],
            [
                'title' => 'Виктор Цой - Звезда по имени Солнце.mp3',
                'artists' => [
                    'Виктор Цой'
                ],
                'file_path' => 'public/music_files/Виктор Цой - Звезда по имени Солнце.mp3',
                'cover_path' => 'public/music_files/viktor-tsoj.jpg',
                'duration' => 204,
                'release_date' => Carbon::now()->toDateTimeString(),
                'is_published' => true,
                'plays' => 0,
                'genre' => MusicGenre::ROCK,
            ],
        ];

        foreach ($musics as $music) {
            $music['file_path'] = $this->fileMv($music['file_path'], 'music');
            $music['cover_path'] = $this->fileMv($music['cover_path'], 'cover');

           $music = Music::query()->firstOrCreate([
                'title' => $music['title'],
                'genre' => $music['genre'],
            ], $music);

           $user->musics()->attach($music->id);
        }
    }

    public function fileMv(string $filePath, string $folderName): string
    {
        // Получаем содержимое файла
        $content = file_get_contents($filePath);

        // Генерируем хешированное имя (md5 + оригинальный расширение)
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $hashedName = md5($filePath . time()) . '.' . $extension;

        // Сохраняем в storage/app/public/music
        $storagePath = $folderName . '/' . $hashedName;

        Storage::disk('public')->put($storagePath, $content);

        // Получаем публичный путь
        return Storage::url($storagePath);
    }
}
