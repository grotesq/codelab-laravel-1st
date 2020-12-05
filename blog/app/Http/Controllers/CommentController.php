<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function create( Request $request, $postId ) {
        $post = Post::find( $postId );

        if( !$post ) {
            return abort( 404 );
        }

        $author = $request->input('author');
        $content = $request->input('content');

        $comment = new Comment();
        $comment->post_id = $post->id;
        $comment->author = $author;
        $comment->content = $content;
        $comment->save();

        return response()->json( $comment );
    }

    public function delete( $postId, $id ) {
        $comment = Comment::where( 'post_id', $postId )->where( 'id', $id )->first();

        if( !$comment ) abort( 404 );

        $comment->delete();

        return response()->json( ['message' => '삭제되었습니다.']);
    }
}
