@extends('layouts.main')

@section('title', $track->title . ' • ' . implode(', ', $track->artists))

@section('content')

    @if ($errors->any())
        <div class="mb-4 rounded-lg bg-red-100 border border-red-400 text-red-700 px-4 py-3">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="min-h-screen bg-gradient-to-b from-gray-50 to-gray-100 dark:from-gray-950 dark:to-gray-900 py-8 md:py-12">

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-5xl">

            <!-- Кнопка назад -->
            <a href="{{ url()->previous() }}" class="inline-flex items-center text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 mb-6 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Назад
            </a>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl overflow-hidden border border-gray-200/50 dark:border-gray-700/50">

                <div class="grid md:grid-cols-5 gap-0">

                    <!-- Большая обложка (левая часть) -->
                    <div class="md:col-span-2 relative aspect-square md:aspect-auto bg-black/5 dark:bg-black/30">

                        @if ($track->cover_path)
                            <img src="{{ asset($track->cover_path) }}"
                                 alt="{{ $track->title }}"
                                 class="w-full h-full object-cover">
                        @else
                            <div class="absolute inset-0 bg-gradient-to-br from-indigo-600 to-purple-700 flex items-center justify-center">
                                <span class="text-white text-9xl opacity-30 font-light">♪</span>
                            </div>
                        @endif

                        <!-- Оверлей с длительностью -->
                        <div class="absolute bottom-4 right-4 bg-black/70 text-white text-sm px-3 py-1.5 rounded-full backdrop-blur-sm">
                            {{ gmdate('i:s', $track->duration) }}
                        </div>
                    </div>

                    <!-- Правая часть — информация + плеер -->
                    <div class="md:col-span-3 p-6 md:p-10 flex flex-col">

                        <div class="flex-1">

                            <!-- Жанр -->
                            <span class="inline-block px-4 py-1.5 rounded-full text-sm font-medium bg-gradient-to-r from-indigo-500/20 to-purple-500/20 text-indigo-700 dark:from-indigo-400/30 dark:to-purple-400/30 dark:text-indigo-300 border border-indigo-500/40 dark:border-indigo-400/50 mb-4">
                                {{ $track->genre->value ?? $track->genre }}
                            </span>

                            <!-- Название трека -->
                            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-3 line-clamp-2">
                                {{ $track->title }}
                            </h1>

                            <!-- Артисты -->
                            <p class="text-xl text-gray-600 dark:text-gray-300 mb-6">
                                {{ implode(', ', $track->artists) }}
                            </p>

                            <!-- Метаданные -->
                            <div class="flex flex-wrap gap-6 text-sm text-gray-500 dark:text-gray-400 mb-8">
                                <div>
                                    <span class="font-medium text-gray-700 dark:text-gray-200">{{ number_format($track->plays) }}</span> прослушиваний
                                </div>
                                <div>
                                    Выпущен: <span class="font-medium text-gray-700 dark:text-gray-200">{{ $track->release_date }}</span>
                                </div>
                            </div>

                            <!-- Плеер -->
                            <div class="mb-10">
                                <audio
                                    controls
                                    autoplay
                                    class="w-full h-14 rounded-xl bg-gray-100/70 dark:bg-gray-900/70 backdrop-blur-sm"
                                    data-track-id="{{ $track->id }}"
                                >
                                    <source src="{{ asset($track->file_path) }}" type="audio/mpeg">
                                    Ваш браузер не поддерживает аудио.
                                </audio>
                            </div>

                            <!-- Кнопки действий -->
                            <div class="flex flex-wrap gap-4">

                                <!-- Избранное -->
                                <form action="{{ route('music.save.favorite', $track->id) }}" method="POST">
                                    @csrf
                                    @if (auth()->check() && $track->isFavoritedBy(auth()->user()))
                                        <button type="submit" title="Убрать из избранного"
                                                class="inline-flex items-center px-6 py-3 bg-red-50 dark:bg-red-950/40 text-red-700 dark:text-red-300 rounded-xl hover:bg-red-100 dark:hover:bg-red-900/60 transition-all shadow-sm">
                                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                            </svg>
                                            В избранном
                                        </button>
                                    @else
                                        <button type="submit" title="Добавить в избранное"
                                                class="inline-flex items-center px-6 py-3 bg-indigo-50 dark:bg-indigo-950/40 text-indigo-700 dark:text-indigo-300 rounded-xl hover:bg-indigo-100 dark:hover:bg-indigo-900/60 transition-all shadow-sm">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                            </svg>
                                            В избранное
                                        </button>
                                    @endif
                                </form>

                                <!-- Поделиться (можно потом расширить) -->
                                <button type="button" onclick="navigator.clipboard.writeText(window.location.href); alert('Ссылка скопирована!');"
                                        class="inline-flex items-center px-6 py-3 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-700 transition-all shadow-sm">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367 2.684m0-6.368a3 3 0 10-5.367 2.684" />
                                    </svg>
                                    Поделиться
                                </button>
                                @if(auth()->user()->isAdmin())
                                <a class="inline-flex items-center px-6 py-3 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-700 transition-all shadow-sm" href="{{ route('music.edit', $track->id) }}">Редактировать</a>
                                @endif
                            </div>
                        </div>

                        <!-- Нижняя информация (автор загрузки, дата и т.д.) -->
                        <div class="mt-10 pt-6 border-t border-gray-200 dark:border-gray-700 text-sm text-gray-500 dark:text-gray-400">
                            Добавлено: {{ $track->created_at->diffForHumans() }}
                            • ID: {{ $track->id }}
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
