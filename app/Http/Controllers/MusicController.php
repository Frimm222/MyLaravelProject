<?php

namespace App\Http\Controllers;

use App\Models\Music;
use App\Services\CacheService;
use App\Services\MusicService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class MusicController extends Controller
{
    public function __construct(
        private readonly CacheService $cacheService,
        private readonly MusicService $musicService,
    )
    {
    }

    public function index(): View
    {
        return view('music.index', [
            'tracks' => $this->cacheService
                ->paginateCache(
                    'music_page_' . request()->get('page', 1),
                    new Music()
                ),
            'pageTitle' => 'All Musics',
        ]);
    }

    public function create(): View
    {
        return view('music.create');
    }

    public function saveFavorite(Music $music): RedirectResponse
    {
        $user = Auth::user();
        $user->musics()->where('id', $music->id)->exists() ?
            $user->musics()->detach($music->id) :
            $user->musics()->attach($music->id);

        return redirect()->back();
    }

    public function trackListenProgress(Request $request): JsonResponse
    {
        return response()->json([
            'plays' => $this->musicService->trackListenProgress($request)->plays,
            'status' => 'success',
        ]);
    }

    public function show(Music $music): View
    {
        return view('music.show', [
            'track' => $this->cacheService->singleCache('music_' . $music->id, $music),
        ]);
    }

    public function edit(Music $music): View|RedirectResponse
    {
        return view('music.edit', [
            'track' => $this->cacheService->singleCache('music_' . $music->id, $music),
        ]);
    }

    public function update(Request $request, Music $music): RedirectResponse
    {
        $music->update($request->all());

        return redirect()->route('music.show', [$music->id]);
    }

    public function delete(Music $music): RedirectResponse
    {
        $music->delete();

        return redirect()->route('music.index')
            ->with('success', 'Successfully deleted music!');
    }

    /**
     * @throws \Throwable
     */
    public function store(Request $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $data = $request->input();
            $fileAudioPath = 'storage/' . $request->file('audio')->store('musics', 'public');
            $fileCoverPath = 'storage/' . $request->file('cover')->store('cover', 'public');
            $data['file_path'] = $fileAudioPath;
            $data['cover_path'] = $fileCoverPath;
            $data['plays'] = 0;
            $music = Music::query()->create($data);
            DB::commit();
        } catch (\Exception $exception) {
            File::delete([
                $fileAudioPath,
                $fileCoverPath
            ]);

            DB::rollBack();
            Log::critical($exception->getMessage());
            return redirect()->back()->with('error', $exception->getMessage());
        }

        return redirect()->route('music.show', $music->id);
    }
}
