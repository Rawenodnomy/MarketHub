<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InfoblockController extends Controller
{
    function getInfoblock ($id){
        $infoblock = DB::select('SELECT * FROM `infoblocks` WHERE id = ?', [$id]);
        $all = DB::select('SELECT * FROM infoblocks');

        if ($infoblock==[]){
            return redirect('/');
        } else {
            $infoblock = $infoblock[0];
            return view('infos.info', compact('infoblock', 'all'));
        }
    }


    function getQuestionsAndAnswers(){
        $questions_answers = DB::select('SELECT * FROM `questions_answers`');

        return view('infos.questions_answers', compact('questions_answers'));
    }
}
