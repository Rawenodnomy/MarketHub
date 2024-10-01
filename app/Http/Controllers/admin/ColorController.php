<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $colors = DB::select('SELECT *, (SELECT COUNT(*) FROM products WHERE products.color_id = colors.id) as count FROM colors ORDER BY name');
        return view('admin.color.index', compact('colors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.color.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::update('INSERT INTO `colors` (`id`, `name`) VALUES (NULL, ?)', [$request->all()['name']]);
        return Redirect('/admin/color')->withSuccess(" Цвет успешно добавлен");
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
        $color = DB::select('SELECT * FROM colors WHERE id = ?', [$id])[0];
        return view('admin.color.edit', compact('color'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::update('UPDATE `colors` SET `name` = ? WHERE `colors`.`id` = ?', [$request->all()['name'], $id]);
        return Redirect()->back()->withSuccess(" Цвет успешно обновлен");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::delete('DELETE FROM `colors` WHERE id = ?', [$id]);
        return Redirect()->back()->withSuccess(" Цвет успешно удален");
    }
}
