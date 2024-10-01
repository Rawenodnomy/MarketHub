@extends('layouts.admin_layout')

@section('title', 'Все Отзывы')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Все Отзывы</h1>
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
                          <th> Пользователь </th>
                          <th> Товар </th>
                          <th> Оценка  </th>
                          <th> Отзыв </th>
                          <th> Дата </th>
                          <th> Удалить </th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reviews as $review)
                        <tr><td>{{$review->id}}</td>
                        <td>{{$review->user_name}}</td>
                        <td>{{$review->product_name}}</td>
                        <td>{{$review->estimation}} </td>
                        <td>{{$review->content}}</td>
                        <td>{{$review->created_at}} </td>

                        <td>
                                    <form action="{{route('reviews.destroy', $review->id)}}" method="post">
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