<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PointController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $points = DB::select('SELECT * FROM `points`');
        $cities = DB::select('SELECT * FROM cities ORDER BY name');

        return view('admin.point.index', compact('points', 'cities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cities = DB::select('SELECT * FROM cities ORDER BY name');
        return view('admin.point.create', compact('cities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::insert('INSERT INTO `points` (`id`, `address`, `city_id`) VALUES (NULL, ?, ?)', [$request->all()['address'], $request->all()['city']]);
        return Redirect('/admin/point')->withSuccess(" Пункт успешно добавлен");
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
        $point = DB::select('SELECT * FROM `points` WHERE id = ?', [$id])[0];
        $cities = DB::select('SELECT * FROM cities ORDER BY name');

        return view('admin.point.edit', compact('point', 'cities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::update('UPDATE `points` SET `address` = ?, `city_id` = ? WHERE `points`.`id` = ?', [$request->all()['address'], $request->all()['city'], $id]);
        return Redirect()->back()->withSuccess(" Пункт успешно обновлен");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::delete('DELETE FROM `points` WHERE id = ?', [$id]);
        return Redirect()->back()->withSuccess(" Пункт успешно удален");
    }
}
