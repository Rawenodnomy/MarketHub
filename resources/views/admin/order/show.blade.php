@extends('layouts.admin_layout')

@section('title', 'Заказ')

@section('content')

<br>
@if (session('success'))
        <div class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert" aira-hidden="true">x</button>
            <h4><i class="icon fa fa-check">{{session('success')}}</i></h4>
        </div>
@endif

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary">
                        <div class="card-body">
                            <div class="form-group">
                        
                                    <div class="row mb-2">
                                        <div class="col-sm-6">
                                            <h1 class="m-0">Заказ №: {{$order->id}}</h1>
                                            <br>
                                            <div style='border: 1px #c0c0c0 solid; padding: 5px; padding-left: 10px; padding-right: 10px; border-radius: 5px;'>
                                            <p>Заказ от: {{$order->created_at}}</p>
                                            <p>Статус от: {{$order->stage}}</p>
                                            <h5>{{$order->count}} товар на общую сумму {{$order->price}} ₽</h5>
                                            </div>
                                        </div>
                                    </div>
                   

                                <label for="exampleInputCategory">Доставка</label>
                                <p style='border: 1px #c0c0c0 solid; padding: 5px; padding-left: 10px; padding-right: 10px; border-radius: 5px;'>
                                Город {{$order->city}}, {{$order->point}}
                                <br>
                                Получатель: {{$order->user}}
                                </p>



                            </div>
<!-- order -->
                        </div>
                        


                </div>
            </div>
        </div>
    </div>
</section>



<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body p-0">
                <table class="table table-striped projects">
                    <thead>
                     <tr> <th style="width: 5%">ID</th>
                            <th> Товар </th>
                            <th> Фото </th>
                            <th> Категория  </th>
                            <th> Цвет  </th>
                            <th> Цена </th>
                            <th> Количество </th>
                            <th> Размер </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                        <tr><td>{{$product->id}}</td>
                        <td>{{$product->name}}</td>
                        <td>
                            <img src="/images/products/{{$product->photo}}" alt="{{$product->photo}}" style='height: 100px; width: 100px; object-fit:cover;'>
                        </td>

                        <td>{{$product->category}}, {{$product->subcategory}}</td>
                        <td>{{$product->color}}</td>
                        <td>{{$product->price}} ₽</td>
                        <td>{{$product->count}}</td>
                        <td>@if($product->size!=null) {{$product->size}} @else Нет @endif</td>

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
        <form action="{{route('order.update', $order->id)}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-footer">
                <button type="submit" name='status' value='{{$next_stage->id}}' class="btn btn-primary">{{$next_stage->stage}}</button>
            </div>
        </form>
    </div>
</div>












@endsection




