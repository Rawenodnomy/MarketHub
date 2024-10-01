<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionAndAnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quesAndAns = DB::select('SELECT * FROM `questions_answers`');

        return view('admin.quesAndAns.index', compact('quesAndAns'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.quesAndAns.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::insert('INSERT INTO `questions_answers` (`id`, `questions`, `answers`) VALUES (NULL, ?, ?)', [$request->all()['que'], $request->all()['ans']]);
        return Redirect('/admin/questAndAns')->withSuccess(" Вопрос-Ответ был успешно добавлен");
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
        $quesAndAns = DB::select('SELECT * FROM `questions_answers` WHERE id = ?', [$id])[0];

        return view('admin.quesAndAns.edit', compact('quesAndAns'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::update('UPDATE `questions_answers` SET `questions` = ?, `answers` = ? WHERE `questions_answers`.`id` = ?', [$request->all()['que'], $request->all()['ans'], $id]);
        return Redirect()->back()->withSuccess(" Вопрос-Ответ был успешно обновлен");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::delete('DELETE FROM `questions_answers` WHERE `questions_answers`.`id` = ?', [$id]);
        return Redirect()->back()->withSuccess(" Вопрос-Ответ был успешно удален");
    }
}
