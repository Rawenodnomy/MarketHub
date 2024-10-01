<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function updateRating(Request $request) {
        $validatedData = $request->validate([
            'product_id' => 'required',
        ]);
    

        $product = Product::where('id', $validatedData['product_id'])->first();
    
        if ($product) {
            $newRating = DB::select('SELECT *, 
                (SELECT COUNT(*) FROM reviews WHERE reviews.product_id = products.id) as count,
                (SELECT SUM(reviews.estimation) FROM reviews WHERE reviews.product_id = products.id) as sum 
                FROM products WHERE id = ?', [$product->id])[0];
    
            if ($newRating->count != 0) {
                $product->rating = $newRating->sum / $newRating->count;
            } else {
                $product->rating = 0;
            }
    
            $product->save();
    
            $reviews = DB::select('SELECT *, 
                (SELECT products.seller_id FROM products WHERE products.id = reviews.product_id) as seller_id 
                FROM reviews HAVING seller_id = ?', [$product->seller_id]);
    
            $countReviews = DB::select('SELECT COUNT(*) as count FROM reviews WHERE product_id = ?', [$validatedData['product_id']])[0]->count;
            
            $sum = 0;
            foreach ($reviews as $item) {
                $sum += $item->estimation;
            }
    
            if (count($reviews) != 0) {
                DB::update('UPDATE sellers SET rating = ? WHERE sellers.id = ?', [$sum / count($reviews), $product->seller_id]);
            } else {
                DB::update('UPDATE sellers SET rating = ? WHERE sellers.id = ?', [0, $product->seller_id]);
            }
    
            return response()->json([
                'success' => true,
                'message' => 'Рейтинг товара обновлен.',
                'newRating' => $product->rating,
                'count' => $countReviews
            ]);
        } else {
            return response()->json(['success' => false, 'message' => 'Товар не найден.'], 404);
        }
    }
}
