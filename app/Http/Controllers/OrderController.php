<?php
/**
 * Created by PhpStorm.
 * User: linuxers
 * Date: 09/03/17
 * Time: 5:43
 */

namespace App\Http\Controllers;


use App\Models\Menus;
use App\Models\OrderItems;
use App\Models\Orders;
use App\Models\TableReservations;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        //
    }

    public function index()
    {
        //
    }

    public function order(Request $request)
    {
        $this->validate($request, [
           'table_id' => 'required|integer'
        ]);

        // check tabel di tabel reservasi
        $check_table = TableReservations::whereTableId($request->table_id)->first();
        if ($check_table) {

            // create order_id
            $order = new Orders();
            $order->table_id = $request->table_id;
            $order->save();

            // mengambil array dari frontend
            $quantity = $request->quantity;
            $food_id = $request->food_id;

            for ($i = 0; $i <  count($food_id); $i++) {

                // query menu untuk mendapatkan total harga yang dipesan customer
                $menu = Menus::whereId($food_id[$i])->first();

                // simpan kedatabase
                OrderItems::create([
                    'order_id' => $order->id,
                    'food_id' => $food_id[$i],
                    'quantity' => $quantity[$i],
                    'total' => $menu->price * $quantity[$i]
                ]);
            }

            // order yang dipesan
            $items = OrderItems::whereOrderId($order->id)->get();
            $order_items = [];
            foreach ($items as $item) {
                $order_items[] = [
                    'id' => $item->id,
                    'name' => $menu->name,
                    'price' => $menu->price,
                    'discount' => $menu->discount,
                    'quantity' => $item->quantity,
                    'total' => $item->total
                ];
            }
            return response()->json($order_items);
        }
        return response()->json(['message' => 'mohon dicek kembali']);
    }

    public function payment(Request $request)
    {
        $this->validate($request, [
            'order_id' => 'required|integer'
        ]);

        // check order
        $check_order = Orders::find($request->order_id);

        if ($check_order) {

            // list semua order pesanan berdasarkan order_id
            $list_order = OrderItems::whereOrderId($request->order_id)->get();
            $order_items = [];
            foreach ($list_order as $item) {
                $menu = Menus::whereId($item->food_id)->first();
                $order_items[] = [
                    'name' => $menu->name,
                    'price' => $menu->price,
                    'discount' => $menu->discount,
                    'quantity' => $item->quantity,
                    'total' => $item->total
                ];
            }

            // total yang harus dibayarkan
            $total_payout = OrderItems::whereOrderId($item->order_id)->sum('total');

            return response()->json(['menu_pesanan' => $order_items, 'total_payout' => $total_payout]);
        }

        return response()->json(['message' => 'and belum memesan order']);
    }

    public function cash(Request $request)
    {
        $this->validate($request,[
           'order_id' => 'required|integer'
        ]);

        // query order_id
        $order_id = Orders::find($request->order_id);
        if ($order_id) {
            $order_id->payment = true;
            $order_id->update();

            // remove tabel reservasi yang sudah membayar
            TableReservations::whereTableId($order_id->table_id)->delete();

            return response()->json(['message' => 'Terima Kasih']);

        }
        return response()->json(['message' => 'order_id tidak terdaftar']);



    }

}