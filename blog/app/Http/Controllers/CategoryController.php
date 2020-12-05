<?php

namespace App\Http\Controllers;

use App\Models\Category;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index() {
        return Category::all();
    }

    public function create(Request $request) {
        return Category::create( $request->only( [ 'name' ] ) );
    }

    public function update( Request $request, $id ) {
        $category = Category::find($id);

        $category->name = $request->input('name');
        $category->save();

        return $category;
    }

    public function delete( $id ) {
        Category::where('id',$id)->delete();
        return [ 'message' => '삭제되었습니다.' ];
    }
}
