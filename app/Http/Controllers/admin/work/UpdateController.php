<?php

namespace App\Http\Controllers\Admin\Work;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $update = DB::select('SELECT *,
        (SELECT products.name FROM products WHERE products.id=update_count.product_id) as name,
        (SELECT products.city_id FROM products WHERE products.id=update_count.product_id) as city,
        (SELECT products.point_id FROM products WHERE products.id=update_count.product_id) as point,
        (SELECT sizes.size FROM sizes WHERE sizes.id=update_count.size_id) as size,
        (SELECT product_galleries.photo FROM product_galleries WHERE product_galleries.product_id=update_count.product_id LIMIT 1) as photo
        FROM update_count HAVING city = ? AND point = ? ORDER BY product_id', [Auth::user()->city_id, Auth::user()->point_id]);
    
    $products = [];
    
    foreach ($update as $item) {
        $productId = $item->product_id;
    
        if (isset($products[$productId])) {
            $products[$productId]['sizes'][$item->size] = $item->count;
        } else {
            $products[$productId] = [
                'id' => $item->product_id,
                'name' => $item->name,
                'city' => $item->city,
                'point' => $item->point,
                'photo' => $item->photo,
                'sizes' => [
                    $item->size => $item->count
                ]
            ];
        }
    }
    

    foreach ($products as &$product) {
        $sizeCountStrings = [];
        foreach ($product['sizes'] as $size => $count) {
            $sizeCountStrings[] = "$size $count шт";
        }
        $product['size'] = implode(', ', $sizeCountStrings);
        unset($product['sizes']);
    }

 
        return view('admin.work.update.index', compact('products'));
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
        $products = DB::select('SELECT *,
        (SELECT products.name FROM products WHERE products.id=update_count.product_id) as name,
        (SELECT sizes.size FROM sizes WHERE sizes.id=update_count.size_id) as size,
        (SELECT product_galleries.photo FROM product_galleries WHERE product_galleries.product_id=update_count.product_id LIMIT 1) as photo
        FROM `update_count` WHERE product_id = ?', [$id]);

        return view('admin.work.update.show', compact('products'));
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
        $update = DB::select('SELECT * FROM `update_count` WHERE product_id = ?', [$id]);
        // dd($update);
        foreach ($update as $item){
            if ($item->size_id==null){
                $count = DB::select('SELECT count FROM products WHERE id = ?', [$item->product_id])[0]->count;
                $newCount = $count+$item->count;
                DB::update('UPDATE `products` SET `count` = ? WHERE `products`.`id` = ?', [$newCount, $item->product_id]);
            } else {
                $have = DB::select('SELECT * FROM `products_sizes` WHERE `product_id` = ? AND size_id = ?', [$item->product_id, $item->size_id]);
                
                if ($have!=[]){
                    $newCount = $have[0]->count + $item->count;
                    DB::update('UPDATE `products_sizes` SET `count` = ? WHERE `products_sizes`.`id` = ?', [$newCount, $have[0]->id]);
                } else {
                    DB::insert('INSERT INTO `products_sizes` (`id`, `product_id`, `size_id`, `count`) VALUES (NULL, ?, ?, ?)', [$item->product_id, $item->size_id, $item->count]);
                }
            }
        }

        DB::delete('DELETE FROM `update_count` WHERE product_id = ?', [$id]);


        
        return Redirect('/admin/work/work_update')->withSuccess("Количество успешно обновлено");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
