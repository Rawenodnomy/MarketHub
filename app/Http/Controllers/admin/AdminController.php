<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index(){

        $productsCount = DB::select('SELECT COUNT(*) as count FROM `products` WHERE status_id = 1')[0]->count;
        $sellersCount = DB::select('SELECT COUNT(*) as count FROM `sellers` WHERE approved = 0')[0]->count;
        $reviewsCount = DB::select('SELECT COUNT(*) as count FROM `reviews`')[0]->count;
        $categoriesCount = DB::select('SELECT COUNT(*) as count FROM categories')[0]->count;
        $subcategoriesCount = DB::select('SELECT COUNT(*) as count FROM subcategories')[0]->count;
        $questionsAnswerCount = DB::select('SELECT COUNT(*) as count FROM questions_answers')[0]->count;
        $citiesCount = DB::select('SELECT COUNT(*) as count FROM cities')[0]->count;
        $pointsCount = DB::select('SELECT COUNT(*) as count FROM points')[0]->count;
        $colorsCount = DB::select('SELECT COUNT(*) as count FROM colors')[0]->count;
        $adminsCount = DB::select('SELECT COUNT(*) as count FROM users WHERE users.is_admin = 1')[0]->count;

        if (Auth::user()->is_admin==1){
            $pointProductsCount = DB::select('SELECT COUNT(*) as count FROM products WHERE city_id=? AND point_id=? AND status_id = 3', [Auth::user()->city_id, Auth::user()->point_id])[0]->count;
            $orderCount = DB::select('SELECT COUNT(*) as count FROM orders  WHERE city_id=? AND address_id=?', [Auth::user()->city_id, Auth::user()->point_id])[0]->count;
            $acceptProductsCount = DB::select('SELECT COUNT(*) as count FROM products WHERE city_id=? AND point_id=? AND status_id = 2', [Auth::user()->city_id, Auth::user()->point_id])[0]->count;
            $products = DB::select('SELECT * FROM products WHERE city_id=? AND point_id=? AND status_id = 3', [Auth::user()->city_id, Auth::user()->point_id]);
            $updateProductCount=0;
            foreach ($products as $item){
                $have = DB::select('SELECT * FROM `update_count` WHERE product_id = ?', [$item->id]);
                if ($have!=[]){
                    $updateProductCount+=1;
                }
            }
        } else {
            $pointProductsCount = 0;
            $orderCount =0;
            $acceptProductsCount = 0;
            $updateProductCount=0;
        }


        return view('admin.home.index', compact('productsCount', 'sellersCount', 'reviewsCount', 'categoriesCount', 'subcategoriesCount', 'questionsAnswerCount', 'citiesCount', 'pointsCount', 'colorsCount', 'adminsCount', 'pointProductsCount', 'orderCount', 'acceptProductsCount', 'updateProductCount'));
    }
}
