<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Comment;
use Illuminate\Http\Request;
use Ramsey\Collection\Collection;

class CommentController extends Controller
{
    public function store(Blog $blog){

        $user = auth()->user();
        if (!$user)
        {
            die('Something went wrong');
        }

        $data = request()->validate([
            'body' => 'required|string|min:1|max:755']);

        $comment = Comment::create(['user_id' => $user->id, 'blog_id' => $blog->id, 'body' => $data['body']]);
        // $comment->save();

        return $comment->id;
    }

    public function delete(Comment $comment){
        $this->authorize('edit-staff',$comment);

        // return response($comment->id, 200);

        $comment->delete();

        return response('done', 200);
    }
}
