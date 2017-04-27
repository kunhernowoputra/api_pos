<?php

namespace App\Http\Controllers;

use App\Models\TableReservations;
use App\Models\Tables;
use Illuminate\Http\Request;

class TableController extends Controller
{
    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
        $reservation = TableReservations::select('table_id')->get();
        $empty_table = Tables::whereNotIn('id', $reservation)->get();
        return response()->json($empty_table);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'seat' => 'required|integer'
        ]);
        // simpan database
        Tables::create($request->all());
        return response()->json(['message' => 'successfully']);
    }

    public function submit(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|integer'
        ]);

        // check table
        $table = Tables::find($request->id);
        if ($table) {
            $reservation = new TableReservations();
            $reservation->table()->associate($table)->save();
            return response()->json(['message' => 'successfully']);
        }
        return response()->json(['message' => 'error']);
    }

}
