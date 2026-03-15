{{-- resources/views/music/show.blade.php --}}
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

                                <!-- Поделиться -->
                                <button type="button" onclick="navigator.clipboard.writeText(window.location.href); alert('Ссылка скопирована!');"
                                        class="inline-flex items-center px-6 py-3 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-700 transition-all shadow-sm">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367 2.684m0-6.368a3 3 0 10-5.367 2.684" />
                                    </svg>
                                    Поделиться
                                </button>

                                @if(auth()->user()?->isAdmin())
                                    <a class="inline-flex items-center px-6 py-3 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-700 transition-all shadow-sm"
                                       href="{{ route('music.edit', $track->id) }}">
                                        Редактировать
                                    </a>
                                @endif
                            </div>
                        </div>

                        <!-- Нижняя информация -->
                        <div class="mt-10 pt-6 border-t border-gray-200 dark:border-gray-700 text-sm text-gray-500 dark:text-gray-400">
                            Добавлено: {{ $track->created_at->diffForHumans() }}
                            • ID: {{ $track->id }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Секция комментариев -->
            <div class="mt-8 bg-white dark:bg-gray-800 rounded-2xl shadow-2xl overflow-hidden border border-gray-200/50 dark:border-gray-700/50">
                <div class="p-6 md:p-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        Комментарии ({{ $track->comments->count() }})
                    </h2>

                    <!-- Форма добавления комментария (только для авторизованных) -->
                    @auth
                        <form action="{{ route('music.comments.store', $track) }}" method="POST" class="mb-8">
                            @csrf
                            <div class="flex gap-4">
                                <img src="{{ auth()->user()->avatar ?? 'https://www.gravatar.com/avatar/?d=mp' }}"
                                     alt="{{ auth()->user()->name }}"
                                     class="w-10 h-10 rounded-full flex-shrink-0">
                                <div class="flex-1">
                                    <textarea
                                        name="text"
                                        rows="3"
                                        placeholder="Напишите комментарий..."
                                        class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                                        required
                                    ></textarea>
                                    <div class="flex justify-end mt-2">
                                        <button type="submit"
                                                class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl transition shadow-sm">
                                            Отправить
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @else
                        <div class="mb-8 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl text-center">
                            <p class="text-gray-600 dark:text-gray-400">
                                <a href="{{ route('login') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">Войдите</a>
                                или
                                <a href="{{ route('register') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">зарегистрируйтесь</a>,
                                чтобы оставить комментарий
                            </p>
                        </div>
                    @endauth

                    <!-- Список комментариев -->
                    <div class="space-y-6" id="comments-list">
                        @forelse($track->comments as $comment)
                            <div class="flex gap-4" id="comment-{{ $comment->id }}">
                                <img src="{{ $comment->user->avatar ?? 'https://www.gravatar.com/avatar/?d=mp' }}"
                                     alt="{{ $comment->user->name }}"
                                     class="w-10 h-10 rounded-full flex-shrink-0">
                                <div class="flex-1">
                                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4">
                                        <div class="flex items-center justify-between mb-2">
                                            <div>
                                                <span class="font-semibold text-gray-900 dark:text-white">
                                                    {{ $comment->user->name }}
                                                </span>
                                                <span class="text-sm text-gray-500 dark:text-gray-400 ml-2">
                                                    {{ $comment->created_at->diffForHumans() }}
                                                </span>
                                            </div>

                                            @if(auth()->id() === $comment->user_id || auth()->user()?->isAdmin())
                                                <div class="flex gap-2">
                                                    <button onclick="editComment({{ $comment->id }})"
                                                            class="text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400 transition">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                        </svg>
                                                    </button>
                                                    <form action="{{ route('music.comments.destroy', $comment) }}"
                                                          method="POST"
                                                          class="inline"
                                                          onsubmit="return confirm('Удалить комментарий?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400 transition">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                        </div>
                                        <p class="text-gray-700 dark:text-gray-300 comment-content">{{ $comment->text }}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-gray-500 dark:text-gray-400 py-8">
                                Пока нет комментариев. Будьте первым!
                            </p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно для редактирования комментария -->
    <div id="editCommentModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 max-w-lg w-full mx-4">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Редактировать комментарий</h3>
            <form id="editCommentForm" method="POST">
                @csrf
                @method('PUT')
                <textarea
                    name="text"
                    id="editCommentContent"
                    rows="4"
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition mb-4"
                    required
                ></textarea>
                <div class="flex justify-end gap-2">
                    <button type="button"
                            onclick="closeEditModal()"
                            class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                        Отмена
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl transition">
                        Сохранить
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function editComment(commentId) {
            const commentElement = document.getElementById(`comment-${commentId}`);
            const content = commentElement.querySelector('.comment-content').textContent;
            const form = document.getElementById('editCommentForm');
            form.action = `/music/comments/${commentId}`;
            document.getElementById('editCommentContent').value = content;
            document.getElementById('editCommentModal').classList.remove('hidden');
            document.getElementById('editCommentModal').classList.add('flex');
        }

        function closeEditModal() {
            document.getElementById('editCommentModal').classList.add('hidden');
            document.getElementById('editCommentModal').classList.remove('flex');
        }

        // Закрытие модального окна по клику вне его
        document.getElementById('editCommentModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditModal();
            }
        });
    </script>

    <style>
        .hidden {
            display: none !important;
        }
    </style>
@endsection
