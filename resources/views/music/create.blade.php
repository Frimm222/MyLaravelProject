@extends('layouts.main')

@section('title', 'Добавить трек')

@section('content')

    <div class="container mx-auto px-4 py-8 max-w-3xl">
        @if ($errors->any())
            <div class="mb-4 rounded-lg bg-red-100 border border-red-400 text-red-700 px-4 py-3">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mb-8 flex items-center justify-between">
            <h1 class="text-3xl font-bold">Добавить трек</h1>
            <a href="{{ route('music.index') }}"
               class="text-indigo-600 dark:text-indigo-400 hover:underline flex items-center">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Назад к списку
            </a>
        </div>

        <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 md:p-8 border border-gray-200 dark:border-gray-700">

            <form action="{{ route('music.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Название -->
                <div class="mb-6">
                    <label class="block text-sm font-medium mb-2">
                        Название трека <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           name="title"
                           value="{{ old('title') }}"
                           required
                           maxlength="255"
                           class="w-full px-4 py-3 rounded-lg border bg-white dark:bg-gray-700 focus:ring-2 focus:ring-indigo-500">
                    @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Артисты -->
                <div class="mb-6">
                    <label class="block text-sm font-medium mb-2">
                        Артист(ы) <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           name="artists"
                           value="{{ old('artists') }}"
                           placeholder="Artist One, Artist Two"
                           required
                           class="w-full px-4 py-3 rounded-lg border bg-white dark:bg-gray-700 focus:ring-2 focus:ring-indigo-500">
                    @error('artists')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Обложка -->
                <div class="mb-6">
                    <label class="block text-sm font-medium mb-2">
                        Обложка <span class="text-red-500">*</span>
                    </label>
                    <input type="file"
                           name="cover"
                           accept="image/*"
                           required
                           class="w-full px-4 py-2 border rounded-lg bg-white dark:bg-gray-700">
                    @error('cover')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Аудио -->
                <div class="mb-6">
                    <label class="block text-sm font-medium mb-2">
                        Аудиофайл (mp3) <span class="text-red-500">*</span>
                    </label>
                    <input type="file"
                           name="audio"
                           accept="audio/mpeg"
                           required
                           class="w-full px-4 py-2 border rounded-lg bg-white dark:bg-gray-700">
                    @error('audio')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Длительность -->
                <div class="mb-6">
                    <label class="block text-sm font-medium mb-2">
                        Длительность (в секундах) <span class="text-red-500">*</span>
                    </label>
                    <input type="number"
                           name="duration"
                           value="{{ old('duration') }}"
                           min="1"
                           required
                           class="w-full px-4 py-3 rounded-lg border bg-white dark:bg-gray-700 focus:ring-2 focus:ring-indigo-500">
                    @error('duration')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Жанр -->
                <div class="mb-6">
                    <label class="block text-sm font-medium mb-2">
                        Жанр <span class="text-red-500">*</span>
                    </label>

                    <select name="genre"
                            class="w-full px-4 py-3 rounded-lg border bg-white dark:bg-gray-700 focus:ring-2 focus:ring-indigo-500"
                            id="genre">
                        @foreach(\App\MusicGenre::options() as $option)
                            <option value="{{ $option['label'] }}">{{ $option['label'] }}</option>
                        @endforeach
                    </select>
                    @error('genre')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Дата релиза -->
                <div class="mb-8">
                    <label class="block text-sm font-medium mb-2">
                        Дата релиза <span class="text-red-500">*</span>
                    </label>
                    <input type="date"
                           name="release_date"
                           value="{{ old('release_date') }}"
                           required
                           class="w-full px-4 py-3 rounded-lg border bg-white dark:bg-gray-700 focus:ring-2 focus:ring-indigo-500">
                    @error('release_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Кнопки -->
                <div class="flex flex-col sm:flex-row gap-4 justify-end">
                    <a href="{{ route('music.index') }}"
                       class="px-6 py-3 bg-gray-200 dark:bg-gray-700 rounded-lg text-center">
                        Отмена
                    </a>

                    <button type="submit"
                            class="px-8 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition shadow-md">
                        Создать трек
                    </button>
                </div>

            </form>
        </div>

    </div>

@endsection
