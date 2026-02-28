<?php

namespace App\Services;

use App\Models\Music;
use Illuminate\Http\Request;

class MusicService
{
    public function trackListenProgress(Request $request): Music
    {
        $track = Music::query()->findOrFail($request->track_id);
        $track->plays += 1;
        $track->save();

        return $track;
    }
}
