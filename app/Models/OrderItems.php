<?php
/**
 * Created by PhpStorm.
 * User: linuxers
 * Date: 09/03/17
 * Time: 7:07
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    protected $fillable = ['order_id', 'food_id', 'quantity', 'total'];
    protected $hidden = ['id'];
    public function order()
    {
        return $this->belongsTo(Orders::class);
    }

}