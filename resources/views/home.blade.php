@extends('layouts.app')

@section('content')
<div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th>Заказ от</th>
                            <th>Пункт выдачи</th>
                            <th>Количество товаров</th>
                            <th>Цена</th>
                            <th>Товары в заказе</th>
                            <th>Статус</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @foreach ($orders as $order)
                            <tr>
                                <td class="align-middle">{{$order->created_at}}</td>
                                <td class="align-middle">Город {{$order->city}}, {{$order->point}}</td>
                                <td class="align-middle">{{$order->count}} шт.</td>
                                <td class="align-middle">{{$order->price}} ₽</td>
                                <td class="align-middle"><button class="btn btn-sm btn-primary show_products" value='{{$order->id}}' data-show='false' id='btn_show_{{$order->id}}'>Показать товары</button></td>
                                @if ($order->status_id == 4)
                                    <td class="align-middle"><button class="btn btn-sm btn-success get_qr" value='{{$order->id}}'>Получить заказ</button></td>
                                @else
                                    <td>{{$order->stage}}</td>
                                @endif
                                <tbody id="product_block_{{$order->id}}"></tbody>
                            </tr>
                        @endforeach
                        
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">{{Auth::user()->name}}</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="border-bottom pb-2">
                        <div class="d-flex justify-content-between">
                            <h6>Всего заказов</h6>
                            <h6>{{$user->order_count}}</h6>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Сумма заказов</h6>
                            <h6 class="font-weight-medium">{{$user->total_sim}}</h6>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Товаров заказано</h6>
                            <h6 class="font-weight-medium">{{$user->product_count}}</h6>
                        </div>
                    </div>
                    <div class="pt-2">
                        <a href='/getFavoriteByUser' class="btn btn-block btn-primary font-weight-bold my-3 py-3">Избранные товары</a>
                        <a class="btn btn-block btn-danger font-weight-bold my-3 py-3" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Выйти') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                    </div>
                </div>

                <div class="bg-light p-30 mb-5 hidden" id='qr-block'>
                    <b><p id='qr-text' style='text-align: center;'></p></b>
                    <p id="order-qr" style='text-align: center;'></p>
                </div>
            </div>
        </div>
    </div>

<script src="/assets/js/user.js" defer type="module"></script>
@endsection
