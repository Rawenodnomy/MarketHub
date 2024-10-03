<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Basket;
use App\Models\City;
use App\Models\Point;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BasketController extends Controller
{
    function getBasket(){
        $basket = Basket::select('baskets.*')
        ->selectSub('SELECT sizes.size FROM sizes WHERE sizes.id=baskets.size_id', 'size')
        ->selectSub('SELECT product_galleries.photo FROM product_galleries WHERE product_galleries.product_id=baskets.product_id LIMIT 1', 'photo')
        ->selectSub('SELECT products.name FROM products WHERE products.id=baskets.product_id', 'name')
        ->selectSub('SELECT products.price FROM products WHERE products.id=baskets.product_id', 'price')
        ->where('user_id', Auth::id())
        ->get();
        return $basket;
    }


    public function addProduct(Request $request){

        $validatedData = $request->validate([
            'product_id' => 'required',
            'size_id' => 'nullable',
            'count' => 'required|min:1',
            'user_id' => 'required',
        ]);

        $basketItem = new Basket();
        $basketItem->product_id = $validatedData['product_id'];
        $basketItem->size_id = $validatedData['size_id'];
        $basketItem->count = $validatedData['count'];
        $basketItem->user_id = $validatedData['user_id'];
        $basketItem->save();

        $countBasket = DB::select('SELECT SUM(count) as count FROM `baskets` WHERE user_id = ?', [Auth::user()->id])[0]->count;

        return response()->json(['success' => true, 'message' => 'Товар добавлен в корзину.', 'count' => $countBasket]);
    }



    public function addBasketProduct(Request $request){

        $validatedData = $request->validate([
            'product_id' => 'required',
            'size_id' => 'nullable',
            'count' => 'required|min:1',
            'user_id' => 'nullable',
        ]);

        $basketItem = Basket::where('product_id', $validatedData['product_id'])
            ->where('size_id', $validatedData['size_id'])
            ->where('user_id', $validatedData['user_id'])
            ->first();

        if ($basketItem) {

            $countProduct = DB::select('SELECT count FROM `products` WHERE id = ?', [$basketItem->product_id])[0];

            if ($countProduct->count==null){
                $countProduct = DB::select('SELECT count FROM `products_sizes` WHERE product_id = ? AND size_id = ?', [$basketItem->product_id, $basketItem->size_id])[0];
            }

            if($validatedData['count']>$countProduct->count){
                $countBasket = DB::select('SELECT SUM(count) as count FROM `baskets` WHERE user_id = ?', [Auth::user()->id])[0]->count;
                return response()->json(['success' => true, 'count'=> $countProduct->count, 'message' => 'Количество товара обновлено.', 'count' => $countBasket]);
            } else {
                $basketItem->count = $validatedData['count'];
                $basketItem->save();
                $countBasket = DB::select('SELECT SUM(count) as count FROM `baskets` WHERE user_id = ?', [Auth::user()->id])[0]->count;
                return response()->json(['success' => true, 'count'=> $validatedData['count'], 'message' => 'Количество товара обновлено.', 'count' => $countBasket]);
            }

        } else {
            return response()->json(['success' => false, 'message' => 'Товар не найден в корзине.'], 404);
        }
    }

    public function decBasketProduct(Request $request){

        $validatedData = $request->validate([
            'product_id' => 'required',
            'size_id' => 'nullable',
            'count' => 'required',
            'user_id' => 'required',
        ]);

        $basketItem = Basket::where('product_id', $validatedData['product_id'])
            ->where('size_id', $validatedData['size_id'])
            ->where('user_id', $validatedData['user_id'])
            ->first();

        if ($basketItem) {
            if ($validatedData['count']==0){
                $basketItem->delete();
            } else {
                $basketItem->count = $validatedData['count'];
                $basketItem->save();
            }

            $countBasket = DB::select('SELECT SUM(count) as count FROM `baskets` WHERE user_id = ?', [Auth::user()->id])[0]->count;

            return response()->json(['success' => true, 'message' => 'Количество товара обновлено.', 'count' => $countBasket]);
        } else {
            return response()->json(['success' => false, 'message' => 'Товар не найден в корзине.'], 404);
        }
    }



    public function getUserBasket(){
        if(!Auth::user()){
            return redirect('/login');
        }
        return view('basket');
    }


    function plusProduct(Request $request){
        $validatedData = $request->validate([
            'id' => 'required',
            'count' => 'required',
        ]);

        $basketItem = Basket::where('id', $validatedData['id'])
            ->first();

        if ($basketItem) {
            $countProduct = DB::select('SELECT count FROM `products` WHERE id = ?', [$basketItem->product_id])[0];
            if ($countProduct->count==null){
                $countProduct = DB::select('SELECT count FROM `products_sizes` WHERE product_id = ? AND size_id = ?', [$basketItem->product_id, $basketItem->size_id])[0];
            }
            if($validatedData['count']+1>$countProduct->count){
                $basketItem->count =$countProduct->count;
                $countBasket = DB::select('SELECT SUM(count) as count FROM `baskets` WHERE user_id = ?', [Auth::user()->id])[0]->count;
                return response()->json(['success' => true, 'newCount'=> $countProduct->count, 'message' => 'Количество товара обновлено.', 'count' => $countBasket]);
            } else {
                $basketItem->count = $validatedData['count']+1;
                $basketItem->save();
                $countBasket = DB::select('SELECT SUM(count) as count FROM `baskets` WHERE user_id = ?', [Auth::user()->id])[0]->count;
                return response()->json(['success' => true, 'newCount'=> $validatedData['count']+1, 'message' => 'Количество товара обновлено.', 'count' => $countBasket]);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Товар не найден в корзине.'], 404);
        }
    }

    function minusProduct(Request $request){
        $validatedData = $request->validate([
            'id' => 'required',
            'count' => 'required',
        ]);

        $basketItem = Basket::where('id', $validatedData['id'])
            ->first();

        if ($basketItem) {
            if ($validatedData['count']!=1){
                $basketItem->count = $validatedData['count']-1;
                $basketItem->save();
                $countBasket = DB::select('SELECT SUM(count) as count FROM `baskets` WHERE user_id = ?', [Auth::user()->id])[0]->count;
                return response()->json(['success' => true, 'newCount' => $validatedData['count']-1, 'count' => $countBasket]);
            } else {
                $basketItem->delete();
                $countBasket = DB::select('SELECT SUM(count) as count FROM `baskets` WHERE user_id = ?', [Auth::user()->id])[0]->count;
                return response()->json(['success' => true, 'newCount' => 0, 'count'=>$countBasket]);
            }
            
        } else {
            return response()->json(['success' => false, 'message' => 'Товар не найден в корзине.'], 404);
        }
    }


    function deleteProduct(Request $request){
        $validatedData = $request->validate([
            'id' => 'required',
        ]);

        $basketItem = Basket::where('id', $validatedData['id'])
        ->first();

        $basketItem->delete();
        $countBasket = DB::select('SELECT SUM(count) as count FROM `baskets` WHERE user_id = ?', [Auth::user()->id])[0]->count;
        return response()->json(['success' => true, 'count' => $countBasket]);
    }


    function getTotalBasket (){
        $sum = \DB::table('baskets')
        ->where('user_id', Auth::id())
        ->join('products', 'baskets.product_id', '=', 'products.id')
        ->selectRaw('SUM(baskets.count * products.price) as sum')
        ->selectRaw('SUM(baskets.count) as count')
        ->first();

        return $sum;
    }


    function BasketToOrders(Request $request){

        $validatedData = $request->validate([
            'total_sum' => 'required',
            'city' => 'required',
            'address' => 'required',
        ]);

        DB::insert('INSERT INTO `orders` (`user_id`, `city_id`, `address_id`, `price`, `created_at`, `updated_at`) VALUES (?, ?, ?, ?, ?, ?)', [Auth::id(), $validatedData['city'], $validatedData['address'], $validatedData['total_sum'], date('Y-m-d'), date('Y-m-d')]);
        $order = DB::getPdo()->lastInsertId();

        DB::update('UPDATE `users` SET `city_id` = ?, `point_id` = ? WHERE `users`.`id` = ?', [$validatedData['city'], $validatedData['address'], Auth::id()]);
        $basket = Basket::where('user_id', Auth::id())->get();
        
        foreach($basket as $item){
            $productPrice = DB::select('SELECT price FROM `products` WHERE id = ?', [$item->product_id]);

            DB::insert('INSERT INTO `orders_products` (`id`, `product_id`, `price`, `size_id`, `count`, `order_id`) VALUES (NULL, ?, ?, ?, ?, ?)', [$item->product_id, $productPrice[0]->price, $item->size_id, $item->count, $order]);
            
            if ($item->size_id!=null){
                $productCount = DB::select('SELECT * FROM `products_sizes` WHERE product_id = ? AND size_id = ?', [$item->product_id, $item->size_id])[0]->count;
                DB::update('UPDATE `products_sizes` SET `count`=? WHERE product_id=? AND size_id=?', [$productCount-$item->count, $item->product_id, $item->size_id]);
            } else {
                $productCount = DB::select('SELECT * FROM `products` WHERE id = ?', [$item->product_id])[0]->count;
                DB::update('UPDATE `products` SET `count` = ? WHERE `products`.`id` = ?', [$productCount-$item->count, $item->product_id]);
            }
            $item->delete();
        }
        return response()->json(['success' => true, 'id'=>$order]);
    }

    function getCity(){
        $have_city=DB::select('SELECT city_id FROM users WHERE users.id = ?', [Auth::id()])[0]->city_id;

        if ($have_city==null){
            $cities = City::orderBy('name')->get();
        } else {
            $cities = City::select('*')
            ->orderByRaw("CASE WHEN id = ? THEN 0 ELSE 1 END", [$have_city])
            ->orderBy('name', 'asc')
            ->get();
        }
        return $cities;
    }


    function getAddress(Request $request){
        $validatedData = $request->validate([
            'id' => 'required',
        ]);

        $have_point=DB::select('SELECT point_id FROM users WHERE users.id = ?', [Auth::id()])[0]->point_id;

        if ($have_point==null){
            $address = Point::select('points.*')
            ->where('city_id', $validatedData['id'])
            ->get();
        } else {
            $address = Point::select('*')
            ->orderByRaw("CASE WHEN id = ? THEN 0 ELSE 1 END", [$have_point])
            ->where('city_id', $validatedData['id'])
            ->get();
        }

        return response()->json(['success' => true, 'address' => $address]);
    }
}
