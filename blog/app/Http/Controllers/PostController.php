<?php

namespace App\Http\Controllers;

use App\Models\Post;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index() {
        $posts = Post::orderBy('created_at', 'desc')
            ->with([ 'categories', 'comments', 'comments.user', 'user' ])
            ->paginate(10);
        return response()->json( $posts );
    }

    public function create( Request $request ) {
        $params = $request->only( [ 'subject', 'content' ] );
        $params['user_id'] = $request->user()->id;
        $post = Post::create($params);
        $ids = $request->input( 'category_ids' );
        // attach, detach, sync
        $post->categories()->sync($ids);
        $result = Post::where('id',$post->id)
            ->with(['user', 'categories'])
            ->first();
        return response()->json($result);
    }

    public function read( $id ) {
        //$post = Post::find($id);
        $post = Post::where('id', $id)
            ->with(['comments', 'comments.user', 'user'])
            ->first();

        if(!$post) {
            return response()
                ->json([ 'message' => '조회할 데이터가 없습니다.' ], 404);
        }

        return response()->json( $post );
    }

    public function update( Request $request, $id ) {
        $post = Post::find( $id );

        if(!$post) {
            return response()
                ->json([ 'message' => '조회할 데이터가 없습니다.' ], 404);
        }

        $user = $request->user();
        if($user->id !== $post->user_id) {
            return response()
                ->json( ['message' => '권한이 없습니다.'], 403);
        }

        $subject = $request->input( 'subject' );
        $content = $request->input( 'content' );
        $ids = $request->input( 'category_ids' );
        
        if( $subject ) $post->subject = $subject;
        if( $content ) $post->content = $content;
        $post->save();
        $post->categories()->sync($ids);

        return response()->json( $post );
    }

    public function delete(Request $request, $id ) {
        // Post::where( 'id', $id )->delete();
        $post = Post::find( $id );

        if(!$post) {
            return response()
                ->json([ 'message' => '조회할 데이터가 없습니다.' ], 404);
        }

        $user = $request->user();
        if($user->id != $post->user_id) {
            return response()
                ->json( ['message' => '권한이 없습니다.'], 403);
        }

        $post->delete();

        return response()->json([ 'message' => '삭제되었습니다.' ]);
    }
}
