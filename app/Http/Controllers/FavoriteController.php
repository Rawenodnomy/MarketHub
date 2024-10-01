<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favourite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class FavoriteController extends Controller
{
    function getFavorite(Request $request){

        $validatedData = $request->validate([
            'product_id' => 'required',
        ]);
        
        $favourite = Favourite::where('user_id', Auth::user()->id)
        ->where('product_id', $validatedData['product_id'])
        ->first();

        if ($favourite) {
            return response()->json(['success' => true, 'message' => 'Товар в избранном.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Товар не найден']);
        }
    }


    function updateFavorite(Request $request){
        $validatedData = $request->validate([
            'product_id' => 'required',
        ]);
        
        $favourite = Favourite::where('user_id', Auth::user()->id)
        ->where('product_id', $validatedData['product_id'])
        ->first();

        if ($favourite){
            $favourite->delete();
            $all_count = DB::select('SELECT COUNT(*) as count FROM `favourites` WHERE user_id = ?', [Auth::user()->id])[0]->count;
            return response()->json(['success' => false, 'message' => '<i class="far fa-heart"></i>',  'count' => $all_count]);
        } else {
            DB::insert('INSERT INTO `favourites` (`id`, `product_id`, `user_id`) VALUES (NULL, ?, ?)', [$validatedData['product_id'], Auth::user()->id]);
            $all_count = DB::select('SELECT COUNT(*) as count FROM `favourites` WHERE user_id = ?', [Auth::user()->id])[0]->count;
            return response()->json(['success' => true, 'message' => '<i class="fa fa-heart"></i>', 'count' => $all_count]);
        }
    }


    function getFavoriteByUser(){
        if(!Auth::user()){
            return redirect('/login');
        }
        $favourites = DB::select('SELECT *,
        (SELECT product_galleries.photo FROM product_galleries WHERE product_galleries.product_id=favourites.product_id LIMIT 1) as photo,
        (SELECT products.name FROM products WHERE products.id=favourites.product_id) as name,
        (SELECT colors.name FROM colors WHERE colors.id = (SELECT products.color_id FROM products WHERE products.id=favourites.product_id)) as color,
        (SELECT products.article FROM products WHERE products.id=favourites.product_id) as article,
        (SELECT products.id FROM products WHERE products.id=favourites.product_id) as product_id,
        (SELECT products.price FROM products WHERE products.id=favourites.product_id) as price
        FROM `favourites` WHERE user_id = ?', [Auth::user()->id]);

        return view('favourites', compact('favourites'));
    }
}
