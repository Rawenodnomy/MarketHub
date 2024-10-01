<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reviews = DB::select('SELECT *,
        (SELECT users.name FROM users WHERE users.id=reviews.user_id) as user_name,
        (SELECT products.name FROM products WHERE products.id=reviews.product_id) as product_name
        FROM `reviews` ORDER BY created_at DESC');

        return view('admin.review.index', compact('reviews'));
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = DB::select('SELECT *,
        (SELECT products.seller_id FROM products WHERE products.id=reviews.product_id) as seller_id
        FROM `reviews` WHERE id = ?', [$id])[0];
        
        DB::delete('DELETE FROM `reviews` WHERE `reviews`.`id` = ?', [$id]);


        $newRating = DB::select('SELECT *, 
            (SELECT COUNT(*) FROM reviews WHERE reviews.product_id=products.id) as count,
            (SELECT SUM(reviews.estimation) FROM reviews WHERE reviews.product_id=products.id) as sum
            FROM products WHERE id = ?', [$data->product_id])[0];

        if ($newRating->count!=0){
            DB::update('UPDATE `products` SET `rating` = ? WHERE `products`.`id` = ?', [$newRating->sum/$newRating->count, $data->product_id]);
        } else {
            DB::update('UPDATE `products` SET `rating` = ? WHERE `products`.`id` = ?', [0, $data->product_id]);
        }
        

        $reviews = DB::select('SELECT *, (SELECT products.seller_id FROM products WHERE products.id=reviews.product_id) as seller_id FROM reviews HAVING seller_id = ?', [$data->seller_id]);

        $sum=0;
        foreach ($reviews as $item){
            $sum += $item->estimation;
        }

        if(count($reviews)!=0){
            DB::update('UPDATE `sellers` SET `rating` = ? WHERE `sellers`.`id` = ?', [$sum/count($reviews), $data->seller_id]);
        } else {
            DB::update('UPDATE `sellers` SET `rating` = ? WHERE `sellers`.`id` = ?', [0, $data->seller_id]);
        }


        return Redirect('/admin/reviews/')->withSuccess("Отзыв был удален");
    }
}
