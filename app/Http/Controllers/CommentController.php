<?php
// app/Http/Controllers/CommentController.php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Music;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index']);
    }

    public function index(Music $track)
    {
        $comments = $track->comments()->with('user')->paginate(20);
        return response()->json($comments);
    }

    public function store(Request $request, Music $track)
    {
        //dd($track);
        $request->validate([
            'text' => 'required|string|min:1|max:1000',
        ]);

        $comment = $track->comments()->create([
            'text' => $request->text,
            'user_id' => Auth::id(),
            'music_id'=> $track->id
        ]);

        $comment->load('user');

        return redirect()->route('music.show', [$track->id])->with('success', 'Комментарий добавлен');
    }

    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $request->validate([
            'text' => 'required|string|min:1|max:1000',
        ]);

        $comment->update([
            'text' => $request->text
        ]);

        return response()->json([
            'success' => true,
            'comment' => $comment,
            'message' => 'Комментарий обновлен'
        ]);
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Комментарий удален'
        ]);
    }
}
