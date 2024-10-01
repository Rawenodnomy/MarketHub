@extends('layouts.admin_layout')

@section('title', 'Все Категории')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Все Категории</h1>
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
        <div class="card">
            <div class="card-body p-0">
                <table class="table table-striped projects">
                    <thead>
                     <tr> <th style="width: 5%">ID</th>
                          <th> Название  </th>
                          <th> Фото </th>
                          <th> Описание  </th>
                          <th> Баннер </th>
                          <th> Баннер фото </th>
                          <th> Просмотр </th>
                          <th> Удалить </th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                        <tr><td>{{$category->id}}</td>
                        <td>{{$category->name}}</td>
                        <td><img src="/images/categories/{{$category->photo}}" alt="{{$category->photo}}" style='width: 150px; height: 150px; object-fit:cover;'></td>
                        <td>{{$category->description}}</td>
                        <td>@if ($category->banner==1) На главной @else Нет @endif</td>
                        <td>@if ($category->banner_photo!=null) <img src="/images/categories/{{$category->banner_photo}}" alt="{{$category->banner_photo}}" style='width: 250px; height: 150px; object-fit:cover;'> @else <img src="/images/categories/{{$category->photo}}" alt="{{$category->photo}}" style='width: 150px; height: 150px; object-fit:cover;'> @endif</td>
                        <td>
                            <a href="{{route('categories.edit', $category->id)}}" class="btn  btn-sm" style="background-color: #4DD54F; color: white;">
                                Просмотр
                            </a>
                        </td>
                        <td>
                            <form action="{{route('categories.destroy', $category->id)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm delete-btn" type="submit">
                                    <i class="fas fa-trash"></i>
                                    Удалить
                                </button>
                            </form>
                        </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

@endsection