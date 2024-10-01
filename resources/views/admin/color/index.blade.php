@extends('layouts.admin_layout')

@section('title', 'Все Цвета')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Все Цвета</h1>
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
                          <th> Цвет </th>
                          <th> Кол-во товаров </th>
                          <th> Редактировать  </th>
                          <th> Удалить </th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($colors as $color)
                        <tr><td>{{$color->id}}</td>
                        <td>{{$color->name}}</td>
                        <td>{{$color->count}}</td>

                        <td>
                            <a href="{{route('color.edit', $color->id)}}" class="btn  btn-sm" style="background-color: #4DD54F; color: white;">
                            Редактировать
                            </a>
                        </td>
                        <td>
                            <form action="{{route('color.destroy', $color->id)}}" method="post">
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