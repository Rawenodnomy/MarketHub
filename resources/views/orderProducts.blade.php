@include ('/layouts/header')


@foreach ($products as $product)

    <hr>
    <p>{{$product->name}}</p>
    <p>{{$product->size}}</p>
    <p>Кол-во: {{$product->count}}</p>
    <p>Цена: {{$product->price}}</p>
    <a href="/getProduct/{{$product->product_id}}">
    <img src="/images/products/{{$product->photo}}" alt="{{$product->photo}}" style='height: 150px;'>
    </a>
    <hr>

@endforeach

@include ('/layouts/footer')
