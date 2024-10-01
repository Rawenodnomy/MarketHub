@extends('layouts.admin_layout')

@section('title', 'Все Товары на пункте')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Все Товары на пункте</h1>
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
                          <th> Размер </th>
                          <th> Количество </th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                        <tr><td>{{$product->product_id}}</td>
                        <td>{{$product->name}}</td>
                        <td><img src="/images/products/{{$product->photo}}" alt="{{$product->photo}}}" style='width: 150px; height: 150px; object-fit:cover;'></td>
                        <td>{{$product->size}}</td>
                        <td>{{$product->count}} шт</td>


                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<div class="card-body">
    <div class="form-group">
        <form action="{{route('work_update.update', $products[0]->product_id)}}" method="post" >
            @csrf
            @method('PUT')
            <div class="card-footer">
                <button type="submit" name='status' class="btn btn-primary">Принять</button>
            </div>
        </form>
    </div>
</div>

@endsection