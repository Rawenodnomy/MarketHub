<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subcategories = DB::select('SELECT * FROM `subcategories`');
        $categories = DB::select('SELECT * FROM `categories`');

        return view('admin.subcategory.index', compact('subcategories', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = DB::select('SELECT * FROM `categories`');

        return view('admin.subcategory.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::insert('INSERT INTO `subcategories` (`id`, `name`, `category_id`) VALUES (NULL, ?, ?)', [$request->all()['name'], $request->all()['category']]);

        return Redirect('/admin/subcategories')->withSuccess(" Подкатегория успешно добавлена");
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
        $subcategory = DB::select('SELECT * FROM `subcategories` WHERE id = ?', [$id])[0];
        $categories = DB::select('SELECT * FROM `categories`');

        return view('admin.subcategory.edit', compact('subcategory', 'categories'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::update('UPDATE `subcategories` SET `name` = ?, `category_id` = ? WHERE `subcategories`.`id` = ?', [$request->all()['name'], $request->all()['category'], $id]);

        return Redirect()->back()->withSuccess(" Подкатегория успешно обновлена");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::delete('DELETE FROM `subcategories` WHERE `subcategories`.`id` = ?', [$id]);
        return Redirect('/admin/subcategories')->withSuccess(" Подкатегория успешно удалена");
    }
}
