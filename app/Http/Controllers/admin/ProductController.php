<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = DB::select('SELECT *, 
        (SELECT categories.name FROM categories WHERE categories.id=products.category_id) as category,
        (SELECT subcategories.name FROM subcategories WHERE subcategories.id=products.subcategory_id) as subcategory,
        (SELECT product_galleries.photo FROM product_galleries WHERE product_galleries.product_id=products.id LIMIT 1) as photo
        FROM `products` WHERE status_id = 1  ORDER BY created_at');

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
        }

        return view('admin.product.index', compact('products'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = DB::select('SELECT *, 
        (SELECT categories.name FROM categories WHERE categories.id=products.category_id) as category,
        (SELECT subcategories.name FROM subcategories WHERE subcategories.id=products.subcategory_id) as subcategory,
        (SELECT colors.name FROM colors WHERE colors.id=products.color_id) as color,
        (SELECT sellers.name FROM sellers WHERE sellers.id=products.seller_id) as seller
        FROM `products` WHERE id = ?', [$id])[0];

        if ($product->count==null){
            $sizes = DB::select('SELECT *, 
            (SELECT sizes.size FROM sizes WHERE sizes.id = products_sizes.size_id) as size 
            FROM `products_sizes` WHERE product_id = ?', [$product->id]);
            $str = '';

            foreach ($sizes as $size){
                $str = $str . $size->size . ' - ' . $size->count . ' шт, ';
            }
            $str = substr($str, 0, -2);
            
            $product->count = $str;

        } else {
            $product->count = $product->count . ' шт';
        }

        $gallery = DB::select('SELECT * FROM `product_galleries` WHERE product_id = ?', [$id]);
        $dop_info = DB::select('SELECT * FROM `additional_information` WHERE product_id = ?', [$id]);

        return view('admin.product.show', compact('product', 'gallery', 'dop_info'));
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
        DB::update('UPDATE `products` SET `status_id` = 2 WHERE `products`.`id` = ?', [$id]);

        return Redirect('/admin/products/')->withSuccess("Статус заявки обновлен на: одобрено");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::update('UPDATE `products` SET `status_id` = 4 WHERE `products`.`id` = ?', [$id]);

        return Redirect('/admin/products/')->withSuccess("Статус заявки обновлен на: отказано");
    }
}
