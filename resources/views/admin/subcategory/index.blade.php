@extends('layouts.admin_layout')

@section('title', 'Все Подкатегории')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Все Подкатегории</h1>
            </div>
            
        </div>
        @if (session('success'))
        <div class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert" aira-hidden="true">x</button>
            <h4><i class="icon fa fa-check"> {{session('success')}}</i></h4>
        </div>
        @endif
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        @foreach ($categories as $category)
        <div class="col-sm-6">
            <h3 class="mb-2">{{$category->name}}</h3>
        </div>
        <div class="card">
            <div class="card-body p-0">
                <table class="table table-striped projects">
                    <thead>
                        <tr>
                            <th style="width: 5%">ID</th>
                            <th>Название</th>
                            <th style="width: 15%" class="text-right">Редактировать</th>
                            <th style="width: 15%" class="text-right">Удалить</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subcategories as $subcategory)
                        @if ($subcategory->category_id == $category->id)
                        <tr>
                            <td>{{$subcategory->id}}</td>
                            <td>{{$subcategory->name}}</td>
                            <td class="text-right">
                                <a href="{{route('subcategories.edit', $subcategory->id)}}" class="btn btn-sm" style="background-color: #4DD54F; color: white;">
                                    Редактировать
                                </a>
                            </td>
                            <td class="text-right">
                                <form action="{{route('subcategories.destroy', $subcategory->id)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm delete-btn" type="submit">
                                        <i class="fas fa-trash"></i>
                                        Удалить
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endforeach
    </div>
</section>

<style>
    .text-right {
        text-align: right;
    }
</style>


@endsection