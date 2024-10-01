@include ('/layouts/header')

@foreach ($orders as $order)
    <hr>
    <p>@if ($order->qr_code==null) как товар будет доставлен, тут появится qr-code @else $order->qr_code @endif</p>
    <p>Статус </p>
    <p>Заказ от {{$order->created_at}}</p>
    <p>Сумма: {{$order->price}}</p>
    <p>Кол-во товаров: {{$order->count}}</p>
    <p>Пункт выдачи: город {{$order->city}}, {{$order->point}}</p>
    <a href="/getOrdersProduct/{{$order->id}}">Товары в заказе</a>
    <hr>
@endforeach

@include ('/layouts/footer')