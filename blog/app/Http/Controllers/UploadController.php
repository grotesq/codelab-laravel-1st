<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function upload(Request $request) {
        $file = $request->file( 'file' );
        
        $dir = date('y/m');
        #$path = $file->store( 'uploads/' . $dir, 's3' );
        $path = $file->storePublicly( 'uploads/' . $dir, 's3' );
        
        return response()->json(['path' => $path]);
    }
}
