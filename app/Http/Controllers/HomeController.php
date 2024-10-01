<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        if (Auth::user()->is_admin==1 || Auth::user()->is_admin==2){
            return redirect('/admin/home');
        }

        $orders = DB::select('SELECT *, 
        (SELECT statuses.stage FROM statuses WHERE statuses.id=orders.status_id) as stage,
        (SELECT cities.name FROM cities WHERE cities.id=orders.city_id) as city,
        (SELECT points.address FROM points WHERE points.id=orders.address_id) as point,
        (SELECT SUM(orders_products.count) FROM orders_products WHERE orders_products.order_id=orders.id) as count
        FROM `orders` WHERE user_id = ?', [Auth::user()->id]);

        $user = DB::select('SELECT *,
        (SELECT COUNT(*) FROM orders WHERE orders.user_id = users.id) as order_count,
        (SELECT SUM(orders_products.count) FROM orders_products WHERE orders_products.order_id IN (SELECT orders.id FROM orders WHERE orders.user_id = users.id)) as product_count,
        (SELECT SUM(orders.price) FROM orders WHERE orders.user_id=users.id) as total_sim
        FROM users WHERE id = ?', [Auth::user()->id])[0];

    
        return view('home', compact('orders', 'user'));
    }


    function getProductsInOrder(Request $request){

        $validatedData = $request->validate([
            'id' => 'required',
        ]);

        $products = DB::select('SELECT *, 
        (SELECT sizes.size FROM sizes WHERE sizes.id=orders_products.size_id) as size, 
        (SELECT products.name FROM products WHERE products.id=orders_products.product_id) as name,
        (SELECT product_galleries.photo FROM product_galleries WHERE product_galleries.product_id=orders_products.product_id LIMIT 1) as photo
        FROM orders_products WHERE order_id = ?', [$validatedData['id']]);



        return response()->json(['success' => false, 'products' => $products]);
    }
}
