<?php
/**
 * Created by PhpStorm.
 * User: linuxers
 * Date: 09/03/17
 * Time: 5:53
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TableReservations extends Model
{
    use SoftDeletes;

    protected $table = 'table_reservations';
    protected $dates = ['delete_at'];

    public function table()
    {
        return $this->belongsTo(Tables::class);
    }

}