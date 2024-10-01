<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    function index(){
        $categories = DB::select('SELECT *, (SELECT COUNT(*) FROM products WHERE products.category_id = categories.id) as count FROM categories');

        $banners = DB::select('SELECT * FROM categories WHERE banner = 1');

        for ($i = 0; $i <count($banners); $i++) {
            $banners[$i]->num=$i;
            
            if ($banners[$i]->banner_photo ==null){
                $banners[$i]->banner_photo = $banners[$i]->photo;
            }
        }
        $subcategories = DB::select('SELECT * FROM `subcategories` ');

        $topSellers = DB::select('SELECT * FROM `sellers` WHERE approved = 1 ORDER BY rating DESC LIMIT 10');
        
        $newProduct = DB::select('SELECT *, 
        (SELECT name FROM subcategories WHERE subcategories.id=products.subcategory_id) as sub,
        (SELECT name FROM sellers WHERE sellers.id=products.seller_id) as seller,
        (SELECT photo FROM product_galleries WHERE product_galleries.product_id=products.id LIMIT 1) as first_photo,
        (SELECT photo FROM product_galleries WHERE product_galleries.product_id=products.id ORDER BY id DESC LIMIT 1) as last_photo,
        (SELECT COUNT(*) FROM reviews WHERE reviews.product_id=products.id) as review_count,
        (SELECT SUM(products_sizes.count) FROM products_sizes WHERE products_sizes.product_id = products.id) as size_count
        FROM `products` WHERE status_id = 3 HAVING count>0 OR size_count>0 ORDER BY created_at DESC LIMIT 8');

        $topProduct = DB::select('SELECT *, 
        (SELECT name FROM subcategories WHERE subcategories.id=products.subcategory_id) as sub,
        (SELECT name FROM sellers WHERE sellers.id=products.seller_id) as seller,
        (SELECT photo FROM product_galleries WHERE product_galleries.product_id=products.id LIMIT 1) as first_photo,
        (SELECT photo FROM product_galleries WHERE product_galleries.product_id=products.id ORDER BY id DESC LIMIT 1) as last_photo,
        (SELECT COUNT(*) FROM reviews WHERE reviews.product_id=products.id) as review_count,
        (SELECT SUM(products_sizes.count) FROM products_sizes WHERE products_sizes.product_id = products.id) as size_count
        FROM `products` WHERE status_id = 3 HAVING count>0 OR size_count>0 ORDER BY rating DESC LIMIT 8');


        if (Auth::user()){
            foreach ($newProduct as $item){
                $fav = DB::select('SELECT * FROM `favourites` WHERE product_id = ? AND user_id = ?', [$item->id, Auth::user()->id]);
                if ($fav!=[]){
                    $item->fav=true;
                } else {
                    $item->fav=false;
                }
            }
            foreach ($topProduct as $item){
                $fav = DB::select('SELECT * FROM `favourites` WHERE product_id = ? AND user_id = ?', [$item->id, Auth::user()->id]);
                if ($fav!=[]){
                    $item->fav=true;
                } else {
                    $item->fav=false;
                }
            }
        }

        return view('welcome', compact('categories', 'newProduct', 'topProduct', 'subcategories', 'banners', 'topSellers'));
    }


    function search (){

        $products = DB::select('SELECT *, 
        (SELECT name FROM sellers WHERE sellers.id = products.seller_id) as seller_name,
        (SELECT photo FROM product_galleries WHERE product_galleries.product_id=products.id LIMIT 1) as photo,
        (SELECT SUM(products_sizes.count) FROM products_sizes WHERE products_sizes.product_id=products.id) as count_size
        FROM products WHERE status_id = 3 HAVING count>0 OR count_size>0');

        return response()->json(['success' => true, 'products' => $products]);
        
    }



}
