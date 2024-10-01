<?php

namespace App\Http\Controllers\Admin\Work;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $id)
    {
        $orders = DB::select('SELECT *,
        (SELECT statuses.stage FROM statuses WHERE statuses.id=orders.status_id) as stage,
        (SELECT SUM(orders_products.count) FROM orders_products WHERE orders_products.order_id=orders.id) as count
        FROM `orders` WHERE city_id = ? AND address_id = ? AND status_id = ?', [Auth::user()->city_id, Auth::user()->point_id, $id->id]);

        $stage = DB::select('SELECT stage FROM statuses WHERE id = ?', [$id->id])[0]->stage;


        return view('admin.work.order.index', compact('orders', 'stage'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = DB::select('SELECT *,
        (SELECT statuses.stage FROM statuses WHERE statuses.id=orders.status_id) as stage,
        (SELECT SUM(orders_products.count) FROM orders_products WHERE orders_products.order_id=orders.id) as count,
        (SELECT users.name FROM users WHERE users.id=orders.user_id) as user,
        (SELECT cities.name FROM cities WHERE cities.id=orders.city_id) as city,
        (SELECT points.address FROM points WHERE points.id=orders.address_id) as point
        FROM `orders` WHERE id = ?', [$id])[0];

        $order_products = DB::select('SELECT *, (SELECT sizes.size FROM sizes WHERE sizes.id=orders_products.size_id) as size FROM `orders_products` WHERE order_id=?', [$id]);
        $products=[];

        foreach ($order_products as $item){
            $product = DB::select('SELECT *,
            (SELECT categories.name FROM categories WHERE categories.id=products.category_id) as category,
            (SELECT subcategories.name FROM subcategories WHERE subcategories.id=products.subcategory_id) as subcategory,
            (SELECT colors.name FROM colors WHERE colors.id=products.color_id) as color,
            (SELECT product_galleries.photo FROM product_galleries WHERE product_galleries.product_id=products.id LIMIT 1) as photo
            FROM products WHERE id = ?', [$item->product_id])[0];


            $product->count = $item->count;
            $product->price = $order->price;
            $product->size = $item->size;

            array_push($products, $product);
        }

        return view('admin.work.order.show', compact('order', 'products'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $point = DB::select('SELECT * FROM `orders` WHERE id = ? AND city_id = ? AND address_id = ?', [$id, Auth::user()->city_id, Auth::user()->point_id]);
        if ($point==[]){
            return Redirect()->back()->withSuccess("Заказ доставляется не на ваш пункт");
        }

        DB::update('UPDATE `orders` SET `status_id` = ? WHERE `orders`.`id` = ?', [$request->all()['status'], $id]);
        return Redirect()->back()->withSuccess("Статус успешно обновлен");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::update('UPDATE `orders` SET `status_id` = ? WHERE `orders`.`id` = ?', [5, $id]);
        return Redirect()->back()->withSuccess("Статус успешно получен");
    }
}
