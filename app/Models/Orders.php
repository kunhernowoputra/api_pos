<?php
/**
 * Created by PhpStorm.
 * User: linuxers
 * Date: 09/03/17
 * Time: 6:47
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $fillable = ['table_id', 'payment'];
    public $timestamps = false;

    public function order_item()
    {
        return $this->hasOne(OrderItems::class);
    }
}