<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageUploadController {

  public function upload(Request $request){
    $fileName=$request->file('file')->getClientOriginalName();
    $path=$request->file('file')->storeAs('uploads', $fileName, 'public');
    return response()->json(['location'=>"/storage/$path"]);

    /*$imgpath = request()->file('file')->store('uploads', 'public');
    return response()->json(['location' => "/storage/$imgpath"]);*/

  }

}