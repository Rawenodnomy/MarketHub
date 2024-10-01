@extends('layouts.admin_layout')

@section('title', 'Заказы')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Заказы в статусе: {{$stage}}</h1>
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
                          <th> Заказ от </th>
                          <th> Цена </th>
                          <th> Количество товаров </th>
                          <th> Просмотр </th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                        <tr><td>{{$order->id}}</td>
                        <td>{{$order->created_at}}</td>
                        <td>{{$order->price}}</td>
                        <td>{{$order->count}}</td>


                        <td>
                            <a href="{{route('work_orders.show', $order->id)}}" class="btn  btn-sm" style="background-color: #4DD54F; color: white;">
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