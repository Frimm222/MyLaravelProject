<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class FavoriteController extends Controller
{
    private const PER_PAGE = 10;

    public function index(): View
    {
        $user = Auth::user();
        $tracks = $user->musics()->paginate(self::PER_PAGE);

        return view('music.index', [
            'tracks' => $tracks,
            'pageTitle' => 'Favorite Musics',
        ]);
    }
}
