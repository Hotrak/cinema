<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Film;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request){
        $comment = new Comment();
        $comment->film_id = $request->film_id;
        $comment->body = $request->comment;
        $comment->user_id = auth()->user()->id;
        $comment->save();
        $comment->user;
        return json_encode($comment);
    }
    public function show($filmId){
        $film = Film::find($filmId);
        $comments = $film->comments;
        foreach ($comments as $comment ){
            $comment->user;
        }
        return json_encode($comments);
    }

    public function delete($id){
        $comment = Comment::find($id);
        $comment->delete();
    }
}
