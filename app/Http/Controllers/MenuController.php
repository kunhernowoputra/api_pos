<?php
/**
 * Created by PhpStorm.
 * User: linuxers
 * Date: 09/03/17
 * Time: 5:27
 */

namespace App\Http\Controllers;



use App\Models\Menus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{

    public function __construct()
    {
        //
    }

    public function index()
    {
        $menu = Menus::all();
        return response()->json($menu);
    }

    public function list_category()
    {
        $category = DB::table('menu_categories')->get();
        return response()->json($category);
    }

    public function create_category(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);
        $category = DB::table('menu_categories')->insert(['name' => $request->name]);
        return response()->json($category);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'menu_category_id' => 'required|integer',
            'name' => 'required',
            'price' => 'required|integer',
            'discount' => 'integer',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->file('image')->isValid()) {
            $image = $request->file('image');
            $imageName = time() .'.'. $image->getClientOriginalExtension();
            $image->move(base_path('public/images/menu/'), $imageName);
        }

        $menu = Menus::create($request->all());
        return response()->json($menu);
    }

}