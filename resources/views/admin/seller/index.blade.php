@extends('layouts.admin_layout')

@section('title', 'Все Заявки Продавцов')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Все Заявки Продавцов</h1>
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
                          <th> Название </th>
                          <th> Тип </th>
                          <th> Организация  </th>
                          <th> Пользователь </th>
                          <th> Просмотр </th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sellers as $seller)
                        <tr><td>{{$seller->id}}</td>
                        <td>{{$seller->name}}</td>
                        <td>{{$seller->org}} </td>
                        <td>{{$seller->organization}}</td>
                        <td>{{$seller->user_name}} </td>

                        <td>
                            <a href="{{route('sellers.show', $seller->id)}}" class="btn  btn-sm" style="background-color: #4DD54F; color: white;">
                                Просмотр
                            </a>
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