<?php
/**
 * Created by PhpStorm.
 * User: linuxers
 * Date: 10/03/17
 * Time: 13:34
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Tables extends Model
{
    protected $fillable = ['name','seat'];

    public function reservation_table()
    {
        return $this->hasOne(TableReservations::class);
    }
}