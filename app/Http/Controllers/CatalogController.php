<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Support\Facades\Auth;

class CatalogController extends Controller
{
    function getCatalog (){
        $products = Product::select('products.*')
        ->selectSub(
            DB::table('subcategories')
                ->select('name')
                ->whereColumn('subcategories.id', 'products.subcategory_id'),
            'sub'
        )
        ->selectSub(
            DB::table('sellers')
                ->select('name')
                ->whereColumn('sellers.id', 'products.seller_id'),
            'seller'
        )
        ->selectSub(
            DB::table('product_galleries')
                ->select('photo')
                ->whereColumn('product_galleries.product_id', 'products.id')
                ->limit(1),
            'photo'
        )
        ->selectSub(
            DB::table('products_sizes')
                ->select(DB::raw('SUM(count)'))
                ->whereColumn('products_sizes.product_id', 'products.id'),
            'size_count'
        )
        ->selectSub('SELECT COUNT(*) FROM reviews WHERE reviews.product_id = products.id', 'count_review')
        ->where('status_id', 3)
        ->having('count', '>', 0)
        ->orHaving('size_count', '>', 0)
        ->inRandomOrder()
        ->get();


        if (Auth::user()){
            foreach ($products as $item){
                $fav = DB::select('SELECT * FROM `favourites` WHERE product_id = ? AND user_id = ?', [$item->id, Auth::user()->id]);
                if ($fav!=[]){
                    $item->fav=true;
                } else {
                    $item->fav=false;
                }
            }
        }

        $categories = DB::select('SELECT *, (SELECT COUNT(*) FROM products WHERE products.category_id=categories.id) as count FROM categories ORDER BY count DESC');


        return view('catalog', compact('products', 'categories'));
    }

    function productByCategory(){

        $products = Product::with(['subcategory', 'seller', 'gallery'])
        ->select('products.*')
        ->selectRaw('(SELECT SUM(count) FROM products_sizes WHERE products_sizes.product_id = products.id) as size_count')
        ->where('status_id', 3)
        ->having('count', '>', 0)
        ->orHaving('size_count', '>', 0)
        ->inRandomOrder()
        ->get()
        ->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'category_id' => $product->category_id,
                'rating' => $product->rating,
                'price' => $product->price,
                'sub_id' => $product->subcategory_id,
                'subcategory' => $product->subcategory->name ?? null,
                'seller' => $product->seller->name ?? null,
                'photo' => $product->gallery->first()->photo ?? null,
                'size_count' => $product->size_count,
            ];
        });
    

        return $products;
    }



    function getSubcategory(){
        $subcategories = Subcategory::select('subcategories.*')
        ->with(['category' => function($query) {
            $query->select('id', 'name'); 
        }])
        ->withCount(['products as count' => function($query) {

        }])
        ->get();
    
    
        return $subcategories;
    }


    function sort(){
        $products = Product::select('products.*')
        ->selectSub('SELECT name FROM subcategories WHERE subcategories.id = products.subcategory_id', 'sub')
        ->selectSub('SELECT name FROM sellers WHERE sellers.id = products.seller_id', 'seller')
        ->selectSub('SELECT photo FROM product_galleries WHERE product_galleries.product_id = products.id LIMIT 1', 'photo')
        ->selectSub('SELECT COUNT(*) FROM reviews WHERE reviews.product_id = products.id', 'count_review')
        ->get();

        if (Auth::user()){
            foreach ($products as $item){
                $fav = DB::select('SELECT * FROM `favourites` WHERE product_id = ? AND user_id = ?', [$item->id, Auth::user()->id]);
                
                if ($fav!=[]){
                    $item->fav=true;
                } else {
                    $item->fav=false;
                }
            }
        }


        return $products;
    }


    function getProduct($id){

        $product = DB::select('SELECT *, 
        (SELECT categories.name FROM categories WHERE categories.id=products.category_id) as category,
        (SELECT subcategories.name FROM subcategories WHERE subcategories.id=products.subcategory_id) as sub,
        (SELECT colors.name FROM colors WHERE colors.id=products.color_id) as color,
        (SELECT sellers.name FROM sellers WHERE sellers.id=products.seller_id) as seller
        FROM `products` WHERE id = ?', [$id])[0];


        $information = DB::select('SELECT * FROM `additional_information` WHERE product_id = ?', [$id]);

        for ($i = 0; $i < count($information); $i++) {
            if ($i<count($information)/2){
                $information[$i]->column=1;
            } else {
                $information[$i]->column=2;
            }
        }

        $gallery = DB::select('SELECT * FROM `product_galleries` WHERE product_id = ?', [$id]);


        foreach ($gallery as $item){
            $item->active = false;
        }

        $gallery[0]->active = true;

        $reviews = DB::select('SELECT *, (SELECT users.name FROM users WHERE users.id=reviews.user_id) as user_name FROM `reviews` WHERE product_id = ? ORDER BY id DESC', [$id]);


        $month = [
            'Января',
            'Февраля',
            'Марта',
            'Апреля',
            'Мая',
            'Июня',
            'Июля',
            'Августа',
            'Сентября',
            'Октября',
            'Ноября',
            'Декабря'
          ];


        foreach ($reviews as $item){
            $day = substr($item->created_at, -2);

            if (substr($day, 0, 1) == 0){
                $day = substr($day, -1);
            }
            $item->created_at = $day . ' ' . $month[substr($item->created_at, 5,2)-1] . ' ' . substr($item->created_at, 0,4);

        }



        $sizes = DB::select('SELECT *, (SELECT sizes.size FROM sizes WHERE sizes.id = products_sizes.size_id) as size FROM `products_sizes` WHERE product_id =? AND count>0', [$id]);

        if (Auth::user()){
            if ($sizes!=[]){
                $inBasket = DB::select('SELECT * FROM `baskets` WHERE user_id = ? AND product_id = ? AND size_id = ?', [Auth::user()->id, $id, $sizes[0]->size_id]);
            } else {
                $inBasket = DB::select('SELECT * FROM `baskets` WHERE user_id = ? AND product_id = ?', [Auth::user()->id, $id]);
            }

        } else {
            $inBasket=null;
        }

        $likeProducts = DB::select('SELECT *, 
        (SELECT COUNT(*) FROM reviews WHERE reviews.product_id = products.id) as count_review,
        (SELECT photo FROM product_galleries WHERE product_galleries.product_id = products.id LIMIT 1) as photo
        FROM products WHERE id != ? AND category_id = ?', [$product->id, $product->category_id]);

        return view('showProduct', compact('product', 'gallery', 'reviews', 'sizes', 'inBasket', 'information', 'likeProducts'));
    }



    function updateFavoriteCatalog(Request $request){
        $validatedData = $request->validate([
            'product_id' => 'required',
        ]);

        $have = DB::select('SELECT * FROM `favourites` WHERE product_id = ? AND user_id = ?', [$validatedData['product_id'], Auth::user()->id]);
        

        if ($have==[]){
            DB::insert('INSERT INTO `favourites` (`id`, `product_id`, `user_id`) VALUES (NULL, ?, ?)', [$validatedData['product_id'], Auth::user()->id]);
            $all_count = DB::select('SELECT COUNT(*) as count FROM `favourites` WHERE user_id = ?', [Auth::user()->id])[0]->count;
            return response()->json(['success' => true, 'product_id' => $validatedData['product_id'], 'add'=>'fa', 'remove'=>'far', 'count' => $all_count]);

        } else {
            DB::delete('DELETE FROM favourites WHERE `favourites`.`id` = ?', [$have[0]->id]);
            $all_count = DB::select('SELECT COUNT(*) as count FROM `favourites` WHERE user_id = ?', [Auth::user()->id])[0]->count;
            return response()->json(['success' => true, 'product_id' => $validatedData['product_id'], 'add'=>'far', 'remove'=>'fa', 'count' => $all_count]);
        }


        
    }




    function getSearchProducts(Request $request){

        $validatedData = $request->validate([
            'ids' => '',
        ]);
        
        $products = Product::select('products.*')
        ->selectSub(
            DB::table('subcategories')
                ->select('name')
                ->whereColumn('subcategories.id', 'products.subcategory_id'),
            'sub'
        )
        ->selectSub(
            DB::table('sellers')
                ->select('name')
                ->whereColumn('sellers.id', 'products.seller_id'),
            'seller'
        )
        ->selectSub(
            DB::table('product_galleries')
                ->select('photo')
                ->whereColumn('product_galleries.product_id', 'products.id')
                ->limit(1),
            'photo'
        )
        ->selectSub(
            DB::table('products_sizes')
                ->select(DB::raw('SUM(count)'))
                ->whereColumn('products_sizes.product_id', 'products.id'),
            'size_count'
        )
        ->selectSub('SELECT COUNT(*) FROM reviews WHERE reviews.product_id = products.id', 'count_review')
        ->where('status_id', 3)
        ->whereIn('products.id', $validatedData['ids'])
        ->having('count_review', '>', 0)
        ->orHaving('size_count', '>', 0)
        ->inRandomOrder()
        ->get();
    


        if (Auth::user()){
            foreach ($products as $item){
                $fav = DB::select('SELECT * FROM `favourites` WHERE product_id = ? AND user_id = ?', [$item->id, Auth::user()->id]);
                if ($fav!=[]){
                    $item->fav=true;
                } else {
                    $item->fav=false;
                }
            }
        }

        $categories = DB::select('SELECT *, (SELECT COUNT(*) FROM products WHERE products.category_id=categories.id) as count FROM categories ORDER BY count DESC');


        return view('catalog', compact('products', 'categories'));
    }


    public function targetPage(Request $request) {
        $ids = json_decode($request->input('ids'));
    
        $products = Product::select('products.*')
        ->selectSub(
            DB::table('subcategories')
                ->select('name')
                ->whereColumn('subcategories.id', 'products.subcategory_id'),
            'sub'
        )
        ->selectSub(
            DB::table('sellers')
                ->select('name')
                ->whereColumn('sellers.id', 'products.seller_id'),
            'seller'
        )
        ->selectSub(
            DB::table('product_galleries')
                ->select('photo')
                ->whereColumn('product_galleries.product_id', 'products.id')
                ->limit(1),
            'photo'
        )
        ->selectSub(
            DB::table('products_sizes')
                ->select(DB::raw('SUM(count)'))
                ->whereColumn('products_sizes.product_id', 'products.id'),
            'size_count'
        )
        ->selectSub('SELECT COUNT(*) FROM reviews WHERE reviews.product_id = products.id', 'count_review')
        ->where('status_id', 3)
        ->whereIn('products.id', $ids)
        ->having('count_review', '>', 0)
        ->orHaving('size_count', '>', 0)
        ->inRandomOrder()
        ->get();
    


        if (Auth::user()){
            foreach ($products as $item){
                $fav = DB::select('SELECT * FROM `favourites` WHERE product_id = ? AND user_id = ?', [$item->id, Auth::user()->id]);
                if ($fav!=[]){
                    $item->fav=true;
                } else {
                    $item->fav=false;
                }
            }
        }

        $categories = DB::select('SELECT *, (SELECT COUNT(*) FROM products WHERE products.category_id=categories.id) as count FROM categories ORDER BY count DESC');


        return view('catalog', compact('products', 'categories'));
    }
}
