<?php

namespace App\Services;

use App\Models\Music;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class CacheService
{
    private const PER_PAGE = 10;

    public function paginateCache(string $key, Model $model): mixed
    {
        if (!Cache::has($key)) {
            Cache::remember(
                $key,
                60,
                fn() => $model->query()->paginate(self::PER_PAGE)
            );
        }

        return Cache::get($key);
    }

    public function singleCache(string $key, Model $model): mixed
    {
        if (Cache::has($key)) {
            return Cache::get($key);
        }

        Cache::put($key, $model, now()->addHours(10));
        return Cache::get($key);
    }
}
