<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;

class BestCommentController extends Controller
{

    public function edit(Comment $comment){
        $this->authorize('update-best-comment', $comment->blog);

        if ($comment->isLiked())
             $comment->state(false);
        else
             $comment->state(true);

        return response('done', 200);
    }
}
