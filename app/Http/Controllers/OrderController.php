<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    function getOrders (){
        $orders = DB::select('SELECT *, 
        (SELECT statuses.stage FROM statuses WHERE statuses.id=orders.status_id) as stage,
        (SELECT cities.name FROM cities WHERE cities.id=orders.city_id) as city,
        (SELECT points.address FROM points WHERE points.id=orders.address_id) as point,
        (SELECT SUM(orders_products.count) FROM orders_products WHERE orders_products.order_id=orders.id) as count
        FROM `orders` WHERE user_id = ?', [Auth::user()->id]);

        return view('orders', compact('orders'));
    }

    function getOrdersProduct($id){
        $products = DB::select('SELECT *, 
        (SELECT sizes.size FROM sizes WHERE sizes.id=orders_products.size_id) as size, 
        (SELECT products.name FROM products WHERE products.id=orders_products.product_id) as name,
        (SELECT product_galleries.photo FROM product_galleries WHERE product_galleries.product_id=orders_products.product_id LIMIT 1) as photo
        FROM orders_products WHERE order_id = ?', [$id]);

        return view('orderProducts', compact('products'));
    }
}
