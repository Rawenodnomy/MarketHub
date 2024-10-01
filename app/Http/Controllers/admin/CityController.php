<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cities = DB::select('SELECT *, (SELECT COUNT(*) FROM points WHERE points.city_id = cities.id) as count FROM cities ORDER BY name');

        return view('admin.city.index', compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.city.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::insert('INSERT INTO `cities` (`id`, `name`) VALUES (NULL, ?)', [$request->all()['name']]);
        return Redirect('/admin/city/')->withSuccess(" Город успешно добавлен");
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
        $city = DB::select('SELECT * FROM cities WHERE id=?', [$id])[0];

        return view('admin.city.edit', compact('city'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::update('UPDATE `cities` SET `name` = ? WHERE `cities`.`id` = ?', [$request->all()['name'], $id]);
        return Redirect()->back()->withSuccess(" Город был успешно обновлен");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::delete('DELETE FROM `cities` WHERE id = ?', [$id]);
        return Redirect()->back()->withSuccess(" Город был успешно удален");
    }
}
