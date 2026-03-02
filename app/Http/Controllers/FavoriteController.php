<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class FavoriteController extends Controller
{
    private const PER_PAGE = 10;

    public function index(): View
    {
        $user = Auth::user();
        $tracks = $user->musics()->paginate(self::PER_PAGE);
        $genres = Genre::orderBy('label')
            ->pluck('label', 'value')
            ->toArray();

        return view('music.index', [
            'tracks' => $tracks,
            'pageTitle' => 'Favorite Musics',
        ], compact('genres'));
    }
}
