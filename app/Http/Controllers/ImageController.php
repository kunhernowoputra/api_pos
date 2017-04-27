<?php
/**
 * Created by PhpStorm.
 * User: linuxers
 * Date: 10/03/17
 * Time: 14:03
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class ImageController extends Controller
{
    public function __construct()
    {
        //
    }

    public function upload(Request $request)
    {
        $this->validate($request,[
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'directory' => 'required'
        ]);

        if ($request->file('image')->isValid()) {
            $image = $request->file('image');
            $imageName = time() .'.'. $image->getClientOriginalExtension();
            $image->move(base_path('public/images/'. $request->directory), '/'.$imageName);
        }

        return $imageName;
    }

}