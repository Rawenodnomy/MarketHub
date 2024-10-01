<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{

    function getReview(Request $request){

        $validatedData = $request->validate([
            'product_id' => 'required',
        ]);
        
        $review = Review::where('user_id', Auth::user()->id)
        ->where('product_id', $validatedData['product_id'])
        ->first();


        if ($review) {
            return response()->json(['success' => true, 'message' => 'Отзыв уже есть']);
        } else {
            return response()->json(['success' => false, 'message' => 'Отзыва еще нет']);
        }
    }


    public function addReview(Request $request){

        $validatedData = $request->validate([
            'user_id' => 'required',
            'content' => 'nullable',
            'product_id' => 'required',
            'estimation' => 'required',
        ]);

        $badwords = ["хуй","пизд","далбо","долбо","уеб","хуе","хуя","пидо","пидр","оху","аху","залу","пезд","еба","еб", "бля", 'морковь', 'терроризм', 'террор', 'война', 'суицид'];
        $pattern = "/\b[а-яё]*(".implode("|", $badwords).")[а-яё]*\b/ui";
        $res = preg_replace($pattern, "***", $validatedData['content']);

        $newReview = new Review();
        $newReview->user_id = $validatedData['user_id'];
        $newReview->content = $res;
        $newReview->product_id = $validatedData['product_id'];
        $newReview->estimation = $validatedData['estimation'];
        $newReview->created_at = date('Y-m-d');

        $newReview->save();

        $date = date('Y-m-d');

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



            $day = substr($date, -2);

            if (substr($day, 0, 1) == 0){
                $day = substr($day, -1);
            }
            $date= $day . ' ' . $month[substr($date, 5,2)-1] . ' ' . substr($date, 0,4);


        return response()->json(['success' => true, 'message' => 'Отзыв успешно добавлен.', 'content' => $res, 'date' => $date]);
    }


    function deleteReview(Request $request){
        $validatedData = $request->validate([
            'product_id' => 'required',
        ]);

        DB::delete('DELETE FROM `reviews` WHERE user_id = ? AND product_id = ?', [Auth::user()->id, $validatedData['product_id']]);

        $count = DB::select('SELECT COUNT(*) as count FROM reviews WHERE product_id = ?',[$validatedData['product_id']])[0]->count;

        return response()->json(['success' => true, 'message' => $validatedData, 'count' => $count]);

    }
}
