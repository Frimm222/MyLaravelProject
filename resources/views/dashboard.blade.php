@extends('layouts.main')
@section('content')
<div class="relative min-h-screen flex items-center justify-center overflow-hidden bg-gradient-to-br from-indigo-950 via-purple-950 to-gray-950">

    <!-- Лёгкий фоновый градиент + шум (опционально через css) -->
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_70%,rgba(99,102,241,0.12),transparent_50%),radial-gradient(circle_at_70%_20%,rgba(168,85,247,0.10),transparent_50%)] pointer-events-none"></div>

    <div class="relative z-10 text-center px-6 max-w-4xl">

        <div class="mb-10 animate-fade-in">
            <span class="inline-block px-5 py-2 rounded-full text-sm font-medium bg-white/10 backdrop-blur-md border border-white/10 text-indigo-300 tracking-wide uppercase">
                Music · Emotion · Moments
            </span>
        </div>

        <h1 class="text-5xl sm:text-6xl md:text-7xl font-extrabold text-white tracking-tight leading-tight mb-6">
            <span class="bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400 bg-clip-text text-transparent">
                Твоя музыка
            </span>
            <br class="sm:hidden">
            <span class="text-4xl sm:text-5xl md:text-6xl opacity-90">
                здесь оживает
            </span>
        </h1>

        <p class="mt-6 text-xl md:text-2xl text-gray-300 max-w-3xl mx-auto leading-relaxed font-light">
            Загружай треки, делись эмоциями, находи новых артистов.<br>
            <span class="text-indigo-300 font-normal">Просто музыка. Без лишнего.</span>
        </p>

        <div class="mt-12 flex flex-col sm:flex-row gap-5 justify-center items-center">

            <a href="{{ route('music.index') }}"
               class="group relative inline-flex items-center px-10 py-5 text-lg font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl shadow-2xl hover:shadow-indigo-500/40 transition-all duration-300 hover:scale-[1.03] active:scale-95 overflow-hidden">
                <span class="absolute inset-0 bg-white/10 group-hover:bg-white/5 transition"></span>
                <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/>
                </svg>
                Начать слушать
            </a>

{{--            <a href="{{ route('music.create') }}"--}}
            <a href="#"
               class="inline-flex items-center px-8 py-4 text-lg font-medium text-indigo-300 border-2 border-indigo-500/40 rounded-2xl hover:bg-indigo-500/10 hover:border-indigo-400 transition-all duration-300 backdrop-blur-sm">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Загрузить свой трек
            </a>

        </div>

        <div class="mt-16 text-sm text-gray-500/80">
            © {{ now()->year }} · Проект, созданный для тех, кто чувствует музыку
        </div>

    </div>

    <!-- Плавающие ноты (чисто декоративно, можно убрать) -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="absolute text-6xl text-white/10 animate-float-slow left-[10%] top-[20%]">♪</div>
        <div class="absolute text-7xl text-purple-300/10 animate-float-medium right-[15%] top-[40%]">♫</div>
        <div class="absolute text-5xl text-indigo-300/15 animate-float-fast bottom-[25%] left-[20%]">♬</div>
    </div>

</div>

<style>
    @keyframes float-slow {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        50%      { transform: translateY(-40px) rotate(10deg); }
    }
    @keyframes float-medium {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        50%      { transform: translateY(-60px) rotate(-8deg); }
    }
    @keyframes float-fast {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        50%      { transform: translateY(-80px) rotate(12deg); }
    }
    .animate-float-slow   { animation: float-slow  18s infinite ease-in-out; }
    .animate-float-medium { animation: float-medium 14s infinite ease-in-out; }
    .animate-float-fast   { animation: float-fast   11s infinite ease-in-out; }
    .animate-fade-in      { animation: fadeIn 1.2s ease-out; }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection
