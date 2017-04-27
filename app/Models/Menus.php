<?php
/**
 * Created by PhpStorm.
 * User: linuxers
 * Date: 09/03/17
 * Time: 5:35
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Menus extends Model
{
    protected $table = 'menus';
    protected $fillable = ['name', 'price', 'discount', 'menu_category_id', 'image'];
    public $timestamps = false;

    public function setImageAttribute($value)
    {
        $this->attributes['image'] = time() .'.'. $value->getClientOriginalExtension();
    }


}