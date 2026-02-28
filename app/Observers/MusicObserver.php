<?php

namespace App\Observers;

use App\Models\Music;
use Illuminate\Support\Facades\Cache;

class MusicObserver
{
    /**
     * Handle the Music "created" event.
     */
    public function created(Music $music): void
    {
        Cache::put('music_' . $music->id, $music, now()->addHours(10));
    }

    /**
     * Handle the Music "updated" event.
     */
    public function updated(Music $music): void
    {
        Cache::put('music_' . $music->id, $music, now()->addHours(10));
    }

    /**
     * Handle the Music "deleted" event.
     */
    public function deleted(Music $music): void
    {
        Cache::forget('music_' . $music->id);
    }

    /**
     * Handle the Music "restored" event.
     */
    public function restored(Music $music): void
    {
        //
    }

    /**
     * Handle the Music "force deleted" event.
     */
    public function forceDeleted(Music $music): void
    {
        //
    }
}
