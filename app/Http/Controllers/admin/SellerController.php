<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sellers = DB::select('SELECT *, 
        (SELECT users.name FROM users WHERE users.id=sellers.user_id) as user_name,
        (SELECT users.email FROM users WHERE users.id=sellers.user_id) as user_email,
        (SELECT organization_types.type FROM organization_types WHERE organization_types.id=sellers.organization_type_id) as org
        FROM `sellers` WHERE approved = 0');

        return view('admin.seller.index', compact('sellers'));
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
        $seller = DB::select('SELECT *, 
        (SELECT users.name FROM users WHERE users.id=sellers.user_id) as user_name,
        (SELECT users.email FROM users WHERE users.id=sellers.user_id) as user_email,
        (SELECT organization_types.type FROM organization_types WHERE organization_types.id=sellers.organization_type_id) as org
        FROM `sellers` WHERE id = ?', [$id])[0];

        return view('admin.seller.show', compact('seller'));
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
        DB::update('UPDATE `sellers` SET `approved` = 1 WHERE `sellers`.`id` = ?', [$id]);

        return Redirect('/admin/sellers/')->withSuccess("Статус продавца обновлен на: одобрено");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $photo = DB::select('SELECT * FROM `sellers` WHERE id = ?', [$id])[0]->photo;

        unlink("images/sellers/".$photo);

        DB::delete('DELETE FROM `sellers` WHERE `sellers`.`id` = ?', [$id]);

        return Redirect('/admin/sellers/')->withSuccess("Статус продавца обновлен на: отказано");
    }
}
