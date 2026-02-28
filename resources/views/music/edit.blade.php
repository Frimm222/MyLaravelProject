@extends('layouts.main')

@section('title', 'Редактировать трек • ' . $track->title)

@section('content')

    <div class="container mx-auto px-4 py-8 max-w-3xl">

        <div class="mb-8 flex items-center justify-between">
            <h1 class="text-3xl font-bold">Редактировать трек</h1>
            <a href="{{ route('music.show', $track->id) }}"
               class="text-indigo-600 dark:text-indigo-400 hover:underline flex items-center">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Назад к треку
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 md:p-8 border border-gray-200 dark:border-gray-700">

            <form action="{{ route('music.update', $track->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <!-- Название трека -->
                <div class="mb-6">
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Название трека <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           name="title"
                           id="title"
                           value="{{ old('title', $track->title) }}"
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
                           required
                           maxlength="255">
                    @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Артисты -->
                <div class="mb-8">
                    <label for="artists" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Артист(ы) <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           name="artists_string"
                           id="artists"
                           value="{{ old('artists_string', implode(', ', $track->artists ?? [])) }}"
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
                           placeholder="Например: Artist One, Artist Two"
                           required>
                    <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">
                        Вводите имена через запятую. Будет автоматически преобразовано в массив.
                    </p>
                    @error('artists_string')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Остальные поля — только просмотр / disabled -->
                <div class="space-y-6 mb-10">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- Обложка (просмотр) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Обложка
                            </label>
                            <div class="relative aspect-square rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-900 border border-gray-200 dark:border-gray-700">
                                @if ($track->cover_path)
                                    <img src="{{ asset($track->cover_path) }}" alt="Обложка" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                                        <span class="text-white text-6xl opacity-40">♪</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Аудио файл (просмотр) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Аудиофайл
                            </label>
                            <audio controls class="w-full mt-1">
                                <source src="{{ asset($track->file_path) }}" type="audio/mpeg">
                            </audio>
                        </div>

                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                        <div>
                            <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">
                                Длительность
                            </label>
                            <input type="text" value="{{ gmdate('i:s', $track->duration) }}" disabled
                                   class="w-full px-4 py-2.5 bg-gray-100 dark:bg-gray-900/50 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 cursor-not-allowed">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">
                                Жанр
                            </label>
                            <input type="text" value="{{ $track->genre?->value ?? $track->genre }}" disabled
                                   class="w-full px-4 py-2.5 bg-gray-100 dark:bg-gray-900/50 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 cursor-not-allowed">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">
                                Дата релиза
                            </label>
                            <input type="text" value="{{ $track->release_date }}" disabled
                                   class="w-full px-4 py-2.5 bg-gray-100 dark:bg-gray-900/50 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 cursor-not-allowed">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">
                                Прослушиваний
                            </label>
                            <input type="text" value="{{ number_format($track->plays) }}" disabled
                                   class="w-full px-4 py-2.5 bg-gray-100 dark:bg-gray-900/50 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 cursor-not-allowed">
                        </div>

                    </div>
                </div>

                <!-- Кнопки -->
                <div class="flex flex-col sm:flex-row gap-4 justify-end">
                    <a href="{{ route('music.show', $track->id) }}"
                       class="px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition text-center">
                        Отмена
                    </a>

                    <button type="submit"
                            class="px-8 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 transition shadow-md">
                        Сохранить изменения
                    </button>
                </div>

            </form>
        </div>

    </div>

@endsection
