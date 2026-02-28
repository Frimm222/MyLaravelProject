@extends('layouts.main')

@section('title', 'Музыка')

@section('content')

    <div class="container mx-auto px-4 py-8">

        <h1 class="text-3xl font-bold mb-8">{{ $pageTitle }}</h1>

        @if ($tracks->isEmpty())
            <p class="text-gray-500 text-center py-12">Пока нет опубликованных треков...</p>
        @else

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

                @foreach ($tracks as $track)
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">

                        <!-- Обложка -->
                        <div class="relative aspect-square">
                            @if ($track->cover_path)
                                <img src="{{ asset($track->cover_path) }}"
                                     alt="{{ $track->title }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div
                                    class="w-full h-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                                    <span class="text-white text-5xl opacity-40">♪</span>
                                </div>
                            @endif

                            <!-- Длительность в углу -->
                            <div class="absolute bottom-2 right-2 bg-black/60 text-white text-xs px-2 py-1 rounded">
                                {{ gmdate('i:s', $track->duration) }}
                            </div>
                        </div>

                        <!-- Информация -->
                        <div class="p-4">
                              <span
                                  class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gradient-to-r from-indigo-500/20 to-purple-500/20 text-indigo-700 dark:from-indigo-400/30 dark:to-purple-400/30 dark:text-indigo-300 border border-indigo-500/30 dark:border-indigo-400/40 backdrop-blur-sm">
                            {{ $track->genre }}
                        </span>

                            <h3 class="font-semibold text-lg mb-1 line-clamp-1">
                                {{ $track->title }}
                            </h3>

                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-3 line-clamp-1">
                                {{ implode(', ', $track->artists) }}
                            </p>


                            <div class="flex items-center justify-between text-sm text-gray-500">
                                <span>Прослушиваний: {{ number_format($track->plays) }}</span>
                                <span>{{ $track->release_date }}</span>
                            </div>

                            <audio
                                controls
                                class="w-full h-10 mt-4"
                                data-track-id="{{ $track->id }}"
                                data-listened="false"
                            >
                                <source src="{{ asset($track->file_path) }}" type="audio/mpeg">
                                Ваш браузер не поддерживает аудио.
                            </audio>


                            <!-- Кнопка "Добавить в избранное / плейлист" -->
                            <div class="mt-3 flex justify-end">
                                <form action="{{ route('music.save.favorite', $track->id) }}" method="POST">
                                    @csrf
                                    @if (in_array($track->id, auth()->user()?->musics->pluck('id')->toArray() ?? []))
                                        <button type="submit"
                                                title="Убрать из избранного"
                                                class="p-2.5 bg-white/80 dark:bg-gray-900/80 rounded-full shadow-md hover:bg-white dark:hover:bg-gray-800 transition-all transform hover:scale-110 active:scale-95">
                                            <svg class="w-7 h-7 text-red-500"
                                                 fill="currentColor"
                                                 viewBox="0 0 24 24">
                                                <path
                                                    d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                            </svg>
                                        </button>
                                    @else
                                        <button type="submit"
                                                title="Добавить в избранное"
                                                class="p-2.5 bg-white/80 dark:bg-gray-900/80 rounded-full shadow-md hover:bg-white dark:hover:bg-gray-800 transition-all transform hover:scale-110 active:scale-95">
                                            <svg class="w-7 h-7 text-gray-400 hover:text-red-400"
                                                 fill="none"
                                                 stroke="currentColor"
                                                 viewBox="0 0 24 24"
                                                 stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                            </svg>
                                        </button>
                                    @endif
                                </form>

                                <div class="mt-3 flex justify-end gap-2">

                                    <a href="{{ route('music.show', $track->id) }}">
                                        <!-- Просмотреть (глаз) -->
                                        <button type="button"
                                                title="Просмотреть"
                                                class="p-2.5 bg-indigo-50 dark:bg-indigo-950/40 rounded-full shadow-md hover:bg-indigo-100 dark:hover:bg-indigo-900/60 transition-all transform hover:scale-110 active:scale-95">
                                            <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400"
                                                 fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </button>
                                    </a>

                                    @if(auth()->user()->isAdmin())
                                        <form action="{{ route('music.delete', $track->id) }}" method="POST"
                                              onsubmit="return confirm('Удалить трек «{{ $track->title }}»?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    title="Удалить трек"
                                                    class="p-2.5 bg-red-50 dark:bg-red-950/40 rounded-full shadow-md hover:bg-red-100 dark:hover:bg-red-900/60 transition-all transform hover:scale-110 active:scale-95">
                                                <svg class="w-6 h-6 text-red-600 dark:text-red-400"
                                                     fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                     stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                @endforeach

            </div>

            <!-- Пагинация -->
            <div class="mt-10">
                {{ $tracks->links() }}
            </div>

        @endif

    </div>


    <script>
        document.addEventListener('DOMContentLoaded', () => {

            // Пороги, которые будем отправлять (можно менять)
            const THRESHOLDS = [1, 10, 25, 50, 75, 90, 100];

            // Отслеживаем все аудио на странице
            document.querySelectorAll('audio[data-track-id]').forEach(audio => {

                const trackId = audio.dataset.trackId;
                let reported = new Set();           // уже отправленные пороги для этого трека
                let lastKnownPercent = 0;

                // Вспомогательная функция отправки
                function reportProgress(percent, isFinal = false) {
                    if (reported.has(percent)) return;

                    fetch("{{ route('music.track.listen_progress') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                        },
                        body: JSON.stringify({
                            track_id: trackId,
                            percent: percent,
                            current_time: Math.round(audio.currentTime),
                            duration: Math.round(audio.duration || 0),
                            completed: isFinal || percent >= 95,
                            timestamp: new Date().toISOString()
                        })
                    })
                        .then(() => {
                            reported.add(percent);
                        })
                        .catch(err => {
                            console.warn(`Ошибка отправки прогресса трека ${trackId}`, err);
                        });
                }

                // Основное событие — обновление времени
                audio.addEventListener('timeupdate', () => {
                    if (audio.paused || !audio.duration) return;

                    const percent = Math.floor((audio.currentTime / audio.duration) * 100);

                    // Проверяем, прошли ли мы новый порог
                    for (let threshold of THRESHOLDS) {
                        if (percent >= threshold && !reported.has(threshold)) {
                            reportProgress(threshold);
                        }
                    }

                    lastKnownPercent = percent;
                });

                // Дослушал до конца
                audio.addEventListener('ended', () => {
                    reportProgress(1, true);
                    audio.dataset.listened = "true";
                });

                // На всякий случай — если человек ушёл со страницы
                window.addEventListener('beforeunload', () => {
                    if (lastKnownPercent >= 10 && !reported.has(100)) {
                        // sendBeacon — надёжнее fetch при выгрузке страницы
                        navigator.sendBeacon(
                            "{{ route('music.track.listen_progress') }}",
                            JSON.stringify({
                                track_id: trackId,
                                percent: lastKnownPercent,
                                current_time: Math.round(audio.currentTime),
                                duration: Math.round(audio.duration || 0),
                                partial: true,
                                timestamp: new Date().toISOString()
                            })
                        );
                    }
                });

                // Можно добавить отправку при паузе после долгого прослушивания (опционально)
                // audio.addEventListener('pause', () => { ... });
            });
        });
    </script>
@endsection
