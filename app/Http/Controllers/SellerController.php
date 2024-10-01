<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class SellerController extends Controller
{
    function createSeller(){

        if(!Auth::user()){
            return redirect('/login');
        }

        $seller = DB::select('SELECT * FROM `sellers` WHERE user_id=?', [Auth::user()->id]);
        
        if ($seller!=[] && $seller[0]->approved==1){
            return redirect('/seller/profile');
        } 

        $types = DB::select('SELECT * FROM `organization_types`');

        return view('seller.sellerCreate', compact('types', 'seller'));;
    }


    function insertSeller(Request $request){
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
        $permitted_chars = substr(str_shuffle($permitted_chars), 0, 10);

        $photo = $permitted_chars . '_' . $_FILES['logo']['name'];

        DB::insert('INSERT INTO `sellers` (`id`, `name`, `organization_type_id`, `organization`, `inn`, `registration_number`, `country`, `legal_address`, `kpp`, `ogrn`, `photo`, `description`, `user_id`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [$request->all()['name'], $request->all()['type'], $request->all()['organization'], $request->all()['inn'], $request->all()['inn'], $request->all()['country'], $request->all()['address'] ?? NULL, $request->all()['kpp'] ?? NULL, $request->all()['ogrn'], $photo, $request->all()['description'], Auth::user()->id]);
    
        move_uploaded_file(
            $_FILES['logo']['tmp_name'],
            'images/sellers/' . $photo
        );


        return redirect('/seller/createSeller');
    }


    function checkSeller (Request $request){

        $validatedData = $request->validate([
            'type' => 'required',
            'inn_value' => 'required',
            'addres_value' => '',
            'kpp_value' => '',
            'ogrn_value' => 'required',
            'organization_value' => 'required',
            'name_value' => 'required'
        ]);


        $err=[];

        $inn = DB::select('SELECT * FROM `sellers` WHERE inn = ?', [$validatedData['inn_value']]);
        $ogrn = DB::select('SELECT * FROM `sellers` WHERE ogrn = ?', [$validatedData['ogrn_value']]);
        $name = DB::select('SELECT * FROM `sellers` WHERE name = ?', [$validatedData['name_value']]);
        $organization = DB::select('SELECT * FROM `sellers` WHERE organization = ?', [$validatedData['organization_value']]);

        if ($inn!=[]){
           array_push($err, [[ "block" => "inn_error", "word" => "Данный ИНН уже используется" ]]);
        }
        if ($ogrn!=[]){
            array_push($err, [[ "block" => "ogrn_error", "word" => "Данный ОГРН уже используется" ]]);
        }



        if ($name!=[]){
            array_push($err, [[ "block" => "name_error", "word" => "Данное название уже используется" ]]);
         }
         if ($organization!=[]){
            array_push($err, [[ "block" => "organization_error", "word" => "Данная Организация  уже используется" ]]);
         }





        if ($validatedData['type']==1){
            $address = DB::select('SELECT * FROM `sellers` WHERE legal_address = ?', [$validatedData['addres_value']]);
            $kpp = DB::select('SELECT * FROM `sellers` WHERE kpp = ?', [$validatedData['kpp_value']]);

            if ($address!=[]){
                array_push($err, [[ "block" => "address_error", "word" => "Данный Адрес  уже используется" ]]);
            }
            if ($kpp!=[]){
                array_push($err, [[ "block" => "kpp_error", "word" => "Данный КПП уже используется" ]]);
            }
        }


        return response()->json(['success' => true, 'err' => $err]);
    }


    function profile(){

        if(!Auth::user()){
            return redirect('/login');
        }

        $check = DB::select('SELECT * FROM `sellers` WHERE user_id = ? AND approved = 1', [Auth::user()->id]);
        if ($check==[]){
            return redirect('/seller/createSeller');
        }

        $seller = DB::select('SELECT *, 
        (SELECT organization_types.type FROM organization_types WHERE sellers.organization_type_id=organization_types.id) as type,
        (SELECT organization_types.reduction FROM organization_types WHERE sellers.organization_type_id=organization_types.id) as reduction 
        FROM `sellers` WHERE user_id = ?', [Auth::user()->id])[0];


        $products = DB::select('SELECT *,
        (SELECT colors.name FROM colors WHERE colors.id = products.color_id) as color,
        (SELECT categories.name FROM categories WHERE categories.id = products.category_id) as category,
        (SELECT subcategories.name FROM subcategories WHERE subcategories.id = products.subcategory_id) as subcategory,
        (SELECT COUNT(*) FROM reviews WHERE reviews.product_id = products.id) as count_reviews
        FROM `products` WHERE seller_id = ?', [$seller->id]);


        foreach ($products as $product){
            // dd($product);
            if ($product->count == null){
                $sizes = DB::select('SELECT *, (SELECT sizes.size FROM sizes WHERE sizes.id=products_sizes.size_id) as size FROM `products_sizes` WHERE product_id = ?', [$product->id]);

                $sizesString = '';
                foreach ($sizes as $size) {
                    $sizesString .= "$size->size: $size->count шт, ";
                }
                $sizesString = rtrim($sizesString, ', ');

                $product->count = $sizesString;
            } else {
                $product->count = $product->count . ' шт';
            }
        }

        return view('seller.profile', compact('products', 'seller'));
    }


    function create(){
        if(!Auth::user()){
            return redirect('/login');
        }

        $check = DB::select('SELECT * FROM `sellers` WHERE user_id = ? AND approved = 1', [Auth::user()->id]);
        if ($check==[]){
            return redirect('/seller/createSeller');
        }
        $categories = DB::select('SELECT * FROM `categories`');
        $colors = DB::select('SELECT * FROM `colors`');

        return view('seller.create', compact('categories', 'colors'));
    }


    function getSubcategories(Request $request){
        $validatedData = $request->validate([
            'category_id' => 'required',
        ]);

        $subcategories = DB::select('SELECT * FROM subcategories WHERE category_id = ?', [$validatedData['category_id']]);
    
        $sizes = DB::select('SELECT * FROM `sizes` WHERE category_id = ?', [$validatedData['category_id']]);

        if ($sizes==[]){
            $sizes=false;
        }

        return response()->json(['success' => true, 'subcategories' => $subcategories, 'sizes' => $sizes]);
    }


    function insertProduct(Request $request){

        $seller = DB::select('SELECT * FROM `sellers` WHERE user_id = ?', [Auth::user()->id])[0];

        DB::insert('INSERT INTO `products` (`name`, `category_id`, `subcategory_id`, `price`, `description`, `count`, `color_id`, `seller_id`, `created_at`, `updated_at`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [$request->all()['name'], $request->all()['category'], $request->all()['subcategory'], $request->all()['price'], $request->all()['description'], $request->all()['count'] ?? NULL, $request->all()['color'], $seller->id, date('Y-m-d'), date('Y-m-d')]);
        
        $product_id = DB::getPdo()->lastInsertId();

        $art = $seller->id . $request->all()['category']  . $request->all()['subcategory'] . $product_id ;
        DB::update('UPDATE `products` SET `article` = ? WHERE products.id = ?', [$art, $product_id]);

        $dop_info = [];

        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'dop') === 0) {
                $index = substr($key, 3);
                $valKey = 'val' . $index;
        
                if (isset($request->all() [$valKey]) && $request->all() [$valKey] !== null && $value !== null) {
                    $dop_info[] = [
                        'dop' => $value,
                        'value' => $request->all() [$valKey],
                    ];
                }
            }
        }
        
        foreach ($dop_info as $item){
            DB::insert('INSERT INTO `additional_information` (`id`, `product_id`, `info`, `value`) VALUES (NULL, ?, ?, ?)', [$product_id, $item['dop'], $item['value']]);
        }


        $size_count = $request->all()['count'] ?? NULL;


        if ($size_count==null){

            foreach ($request->all() as $key => $value) {
                if (strpos($key, 'size_') === 0) { 
                    $word = 'count_' . $key;

                    DB::insert('INSERT INTO `products_sizes` (`id`, `product_id`, `size_id`, `count`) VALUES (NULL, ?, ?, ?)', [$product_id, $value, $request->all()[$word]]);
                }
            }
        }

        $count = count($_FILES['images']['name']);
        $i = 0;

        while ($i<$count) {
            $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
            $permitted_chars = substr(str_shuffle($permitted_chars), 0, 10);
            $photo = $permitted_chars . '_' . $_FILES['images']['name'][$i];

            DB::insert('INSERT INTO `product_galleries` (`id`, `photo`, `product_id`) VALUES (NULL, ?, ?)', [$photo, $product_id]);
            move_uploaded_file(
                $_FILES['images']['tmp_name'][$i],
                'images/products/' . $permitted_chars . '_' . $_FILES['images']['name'][$i]
            );
            $i=$i+1;
        }


        return redirect('/seller/getProducts');
    }



    function getProducts (){
        if(!Auth::user()){
            return redirect('/login');
        }

        $check = DB::select('SELECT * FROM `sellers` WHERE user_id = ? AND approved = 1', [Auth::user()->id]);
        if ($check==[]){
            return redirect('/seller/createSeller');
        }
        
        $seller = DB::select('SELECT * FROM `sellers` WHERE user_id = ?', [Auth::user()->id])[0];

        $products = DB::select('SELECT *,
        (SELECT products_statuses.stage FROM products_statuses WHERE products_statuses.id = products.status_id) as stage,
        (SELECT subcategories.name FROM subcategories WHERE subcategories.id = products.subcategory_id) as sub,
        (SELECT categories.name FROM categories WHERE categories.id = products.category_id) as category,
        (SELECT product_galleries.photo FROM product_galleries WHERE product_galleries.product_id = products.id LIMIT 1) as photo
        FROM `products` WHERE seller_id = ? ORDER BY status_id', [$seller->id]);

        foreach ($products as $item){
            if ($item->count==null){
                $sizes = DB::select('SELECT *, 
                (SELECT sizes.size FROM sizes WHERE sizes.id = products_sizes.size_id) as size 
                FROM `products_sizes` WHERE product_id = ?', [$item->id]);
                $str = '';

                foreach ($sizes as $size){
                    $str = $str . $size->size . ' - ' . $size->count . ' шт, ';
                }
                $str = substr($str, 0, -2);
                
                $item->count = $str;

            } else {
                $item->count = $item->count . ' шт';
            }

            $update = DB::select('SELECT * FROM `update_count` WHERE product_id = ?', [$item->id]);

            if ($update!=[]){
                $item->stage = $item->stage . ', ожидает поступление на склад';
                $item->update = true;
            } else {
                $item->update = false;
            }
        }


        return view('seller.products', compact('products'));
    }



    function checkUpdateCount(Request $request){

        $validatedData = $request->validate([
            'id' => 'required',
        ]);

        $product = DB::select('SELECT * FROM products WHERE id = ?', [$validatedData['id']]);

        $sizes = DB::select('SELECT * FROM `sizes` WHERE category_id = ?', [$product[0]->category_id]);

        return response()->json(['success' => true, 'sizes' => $sizes, 'product_id' =>$validatedData['id']]);
    }


    function updateCount(Request $request){
        $validatedData = $request->validate([
            'array_count' => 'required',
            'size_array' => 'required',
        ]);

        if ($validatedData['size_array']=='true'){

            foreach ($validatedData['array_count'] as $item){
                DB::insert('INSERT INTO `update_count` (`id`, `product_id`, `size_id`, `count`) VALUES (NULL, ?, ?, ?)', [$item['product_id'], $item['size_id'], $item['count']]);
            }

        } else {
            DB::insert('INSERT INTO `update_count` (`id`, `product_id`, `size_id`, `count`) VALUES (NULL, ?, NULL, ?)', [$validatedData['array_count'][0]['product_id'], $validatedData['array_count'][0]['count']]);
        }

        return response()->json(['success' => true]);
        
    }



    function getSeller($id){
        $seller = DB::select('SELECT *, 
        (SELECT organization_types.type FROM organization_types WHERE sellers.organization_type_id=organization_types.id) as type,
        (SELECT organization_types.reduction FROM organization_types WHERE sellers.organization_type_id=organization_types.id) as reduction 
        FROM `sellers` WHERE id = ?', [$id])[0];

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
        ->Where('seller_id', $id)
        ->having('count', '>', 0)
        ->orHaving('size_count', '>', 0)
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


        return view('seller.catalog', compact('seller', 'products'));
    }



}
