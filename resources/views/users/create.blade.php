@extends('layouts.main')

@section('content')
    <div class="container mx-auto px-4 py-8 max-w-3xl">

        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                        Новый пользователь
                    </h1>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">
                        Добавление нового аккаунта в систему
                    </p>
                </div>

                <a href="{{ route('users.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700
                      hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200
                      font-medium rounded-lg transition-colors">
                    ← Назад к списку
                </a>
            </div>
        </div>

        <!-- Card -->
        <div class="bg-white dark:bg-gray-800 shadow-xl rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">

            <div class="p-6 sm:p-8">

                <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="space-y-6">

                        <!-- Аватар + имя -->
                        <div class="flex flex-col sm:flex-row sm:items-start gap-6">
                            <div class="flex-shrink-0">
                                <div class="h-20 w-20 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600
                                        flex items-center justify-center text-white font-bold text-3xl shadow-md overflow-hidden">
                                    <img id="avatar-preview" src="" alt="" class="hidden w-full h-full object-cover">
                                    <span id="avatar-placeholder">?</span>
                                </div>
                            </div>

                            <div class="flex-1 space-y-4">
                                <div>
                                    <label for="avatar" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Аватар (опционально)
                                    </label>
                                    <input type="file"
                                           name="avatar"
                                           id="avatar"
                                           accept="image/jpeg,image/png,image/webp,image/gif"
                                           class="block w-full text-sm text-gray-500 dark:text-gray-400
                                              file:mr-4 file:py-2 file:px-4
                                              file:rounded-lg file:border-0
                                              file:text-sm file:font-medium
                                              file:bg-indigo-50 file:text-indigo-700
                                              hover:file:bg-indigo-100
                                              dark:file:bg-indigo-900/30 dark:file:text-indigo-400
                                              dark:hover:file:bg-indigo-900/50
                                              cursor-pointer">

                                    @error('avatar')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Имя пользователя <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text"
                                           name="name"
                                           id="name"
                                           value="{{ old('name') }}"
                                           required
                                           autocomplete="name"
                                           class="block w-full rounded-lg border-gray-300 dark:border-gray-600
                                              dark:bg-gray-700 dark:text-white shadow-sm
                                              focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2.5
                                              @error('name') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">

                                    @error('name')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email"
                                   name="email"
                                   id="email"
                                   value="{{ old('email') }}"
                                   required
                                   autocomplete="email"
                                   class="block w-full rounded-lg border-gray-300 dark:border-gray-600
                                      dark:bg-gray-700 dark:text-white shadow-sm
                                      focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2.5
                                      @error('email') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">

                            @error('email')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Пароль -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Пароль <span class="text-red-500">*</span>
                            </label>
                            <input type="password"
                                   name="password"
                                   id="password"
                                   required
                                   autocomplete="new-password"
                                   class="block w-full rounded-lg border-gray-300 dark:border-gray-600
                                      dark:bg-gray-700 dark:text-white shadow-sm
                                      focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2.5
                                      @error('password') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">

                            @error('password')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Подтверждение пароля -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Подтверждение пароля <span class="text-red-500">*</span>
                            </label>
                            <input type="password"
                                   name="password_confirmation"
                                   id="password_confirmation"
                                   required
                                   class="block w-full rounded-lg border-gray-300 dark:border-gray-600
                                      dark:bg-gray-700 dark:text-white shadow-sm
                                      focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2.5">
                        </div>

                        <!-- Кнопки -->
                        <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200 dark:border-gray-700 mt-8">
                            <a href="{{ route('users.index') }}"
                               class="px-5 py-2.5 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600
                                  text-gray-800 dark:text-gray-200 font-medium rounded-lg transition">
                                Отмена
                            </a>

                            <button type="submit"
                                    class="inline-flex items-center px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700
                                       text-white font-medium rounded-lg shadow-md transition-all duration-200
                                       focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Создать пользователя
                            </button>
                        </div>

                    </div>
                </form>

            </div>
        </div>

    </div>

    <!-- Превью аватарки -->
    <script>
        document.getElementById('avatar').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('avatar-preview');
            const placeholder = document.getElementById('avatar-placeholder');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                }
                reader.readAsDataURL(file);
            } else {
                preview.src = '';
                preview.classList.add('hidden');
                placeholder.classList.remove('hidden');
            }
        });
    </script>

@endsection
