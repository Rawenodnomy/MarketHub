<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = DB::select('SELECT * FROM `categories`');

        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = DB::select('SELECT * FROM `categories`');
        return view('admin.category.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $banner;

        if (!empty($request->all()['banner'])){
            $banner=1;
        } else {
            $banner=0;
        }
        
        if (!empty($request->all()['photo_banner'])){
            $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
            $permitted_chars = substr(str_shuffle($permitted_chars), 0, 10);
    
            $banner_photo = $permitted_chars . '_' . $_FILES['photo_banner']['name'];

        } else {
            $banner_photo = null;
        }


        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
        $permitted_chars = substr(str_shuffle($permitted_chars), 0, 10);

        $photo = $permitted_chars . '_' . $_FILES['photo']['name'];



        DB::insert('INSERT INTO `categories` (`id`, `name`, `photo`, `description`, `banner`, `banner_photo`) VALUES (NULL, ?, ?, ?, ?, ?)', [$request->all()['name'], $photo, $request->all()['description'], $banner, $banner_photo]);



        move_uploaded_file(
            $_FILES['photo']['tmp_name'],
            'images/categories/' . $photo
        );


        if (!empty($request->all()['photo_banner'])){
            move_uploaded_file(
                $_FILES['photo_banner']['tmp_name'],
                'images/categories/' . $banner_photo
            );
        }




        return redirect('/admin/categories')->withSuccess(' Категория успешно добавлена');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = DB::select('SELECT * FROM `categories` WHERE id = ?', [$id])[0];

        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all(), $id);
        $banner;
        $photo;
        $banner_photo;

        if (!empty($request->all()['banner'])){
            $banner=1;
        } else {
            $banner=0;
        }


        if (empty($request->all()['newphoto'])){
            $photo = $request->all()['oldphoto'];
        } else {
            $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
            $permitted_chars = substr(str_shuffle($permitted_chars), 0, 10);
    
            $photo = $permitted_chars . '_' . $_FILES['newphoto']['name'];

            unlink("images/categories/".$request->all()['oldphoto']);
        }

        if (empty($request->all()['newBanner'])){
            $banner_photo = $request->all()['bannerphoto'];
        } else {
            $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
            $permitted_chars = substr(str_shuffle($permitted_chars), 0, 10);
    
            $banner_photo = $permitted_chars . '_' . $_FILES['newBanner']['name'];

            if ($request->all()['bannerphoto']!=null){
                unlink("images/categories/".$request->all()['bannerphoto']);
            }
        }

        DB::update('UPDATE `categories` SET `name` = ?, `photo` = ?, `description` = ?, `banner` = ?, `banner_photo` = ? WHERE `categories`.`id` = ?', [$request->all()['name'], $photo, $request->all()['description'], $banner, $banner_photo, $id]);

        


        if (!empty($request->all()['newphoto'])){
            move_uploaded_file(
                $_FILES['newphoto']['tmp_name'],
                'images/categories/' . $photo
            );
        }


        if (!empty($request->all()['newBanner'])){
            move_uploaded_file(
                $_FILES['newBanner']['tmp_name'],
                'images/categories/' . $banner_photo
            );
        }


        return redirect()->back()->withSuccess(' Категория успешно обновлена');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $photos = DB::select('SELECT photo, banner_photo FROM categories WHERE id = ?', [$id])[0];
        unlink("images/categories/".$photos->photo);

        if ($photos->banner_photo != null){
            unlink("images/categories/".$photos->banner_photo);
        }
        
        DB::delete('DELETE FROM `categories` WHERE `categories`.`id` = ?', [$id]);
        
        return redirect()->back()->withSuccess(' Категория успешно удалена');
    }
}
