@extends('layouts.main')
@section('content')
        <div class="container mx-auto px-4 py-8 max-w-3xl">
            @if (session('success'))
                <div class="fixed top-4 right-4 z-50 animate-fade-in">
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-lg max-w-md">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <p class="font-medium">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                            Редактирование пользователя
                        </h1>
                        <p class="mt-2 text-gray-600 dark:text-gray-400">
                            Изменение данных: {{ $user->name }}
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

                    <form method="POST" action="{{ route('users.update', $user->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">

                            <!-- Аватар + имя -->
                            <div class="flex flex-col sm:flex-row sm:items-center gap-6">
                                <div class="flex-shrink-0">
                                    <div class="h-20 w-20 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600
                                            flex items-center justify-center text-white font-bold text-3xl shadow-md">
                                      @if($user->avatar) <img src="{{ asset($user->avatar->path) }}"> @else {{ strtoupper(substr($user->name, 0, 1)) }} @endif
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Имя пользователя
                                    </label>
                                    <input type="text"
                                           name="name"
                                           id="name"
                                           value="{{ old('name', $user->name) }}"
                                           class="block w-full rounded-lg border-gray-300 dark:border-gray-600
                                              dark:bg-gray-700 dark:text-white shadow-sm
                                              focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2.5
                                              @error('name') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">

                                    @error('name')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Email
                                </label>
                                <input type="email"
                                       name="email"
                                       id="email"
                                       value="{{ old('email', $user->email) }}"
                                       class="block w-full rounded-lg border-gray-300 dark:border-gray-600
                                          dark:bg-gray-700 dark:text-white shadow-sm
                                          focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2.5
                                          @error('email') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror">

                                @error('email')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Пароль (опционально) -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Новый пароль <span class="text-gray-500 dark:text-gray-400 text-xs">(оставьте пустым, если не меняете)</span>
                                </label>
                                <input type="password"
                                       name="password"
                                       id="password"
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
                                    Подтверждение пароля
                                </label>
                                <input type="password"
                                       name="password_confirmation"
                                       id="password_confirmation"
                                       class="block w-full rounded-lg border-gray-300 dark:border-gray-600
                                          dark:bg-gray-700 dark:text-white shadow-sm
                                          focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2.5">
                            </div>

                            <!-- Кнопки -->
                            <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                                <a href="{{ route('users.index') }}"
                                   class="px-5 py-2.5 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600
                                      text-gray-800 dark:text-gray-200 font-medium rounded-lg transition">
                                    Отмена
                                </a>

                                <button type="submit"
                                        class="inline-flex items-center px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700
                                           text-white font-medium rounded-lg shadow-md transition-all duration-200
                                           focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    Сохранить изменения
                                </button>
                            </div>

                        </div>
                    </form>

                </div>
            </div>

        </div>
@endsection
