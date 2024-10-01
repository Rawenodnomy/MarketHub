<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $workers = DB::select('SELECT *,
        (SELECT cities.name FROM cities WHERE cities.id = users.city_id) as city,
        (SELECT points.address FROM points WHERE points.id = users.point_id) as point
        FROM `users` WHERE is_admin=1 ORDER BY city');

        return view('admin.worker.index', compact('workers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cities = DB::select('SELECT * FROM cities ORDER BY name');
        return view('admin.worker.create', compact('cities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        DB::insert('INSERT INTO `users` (`name`, `email`, `city_id`, `point_id`, `is_admin`, `password`) VALUES (?, ?, ?, ?, ?, ?)', [$request->all()['name'], $request->all()['email'], $request->all()['city'], $request->all()['address'], 1, password_hash($request->all()['password'], PASSWORD_DEFAULT)]);

        return Redirect('/admin/worker')->withSuccess(" Работник успешно добавлен");

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
        DB::update('UPDATE `users` SET `is_admin` = 0 WHERE `users`.`id` = ?', [$id]);
        return Redirect()->back()->withSuccess(" Работник успешно удален");
    }
}
