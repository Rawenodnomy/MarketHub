@extends('layouts.admin_layout')

@section('title', 'Просмотр товара')

@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Товар: №{{$product->id}}</h1>
          </div><!-- /.col -->

        </div><!-- /.row -->
        @if (session('success'))
        <div class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert" aira-hidden="true">x</button>
            <h4><i class="icon fa fa-check"> {{session('success')}}</i></h4>
        </div>
        @endif
      </div><!-- /.container-fluid -->
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Название</label>
                                <h4 class="form-control" id='name'>{{$product->name}}</h4>

                                <label for="price">Цена</label>
                                <h4 class="form-control" id='price'>{{$product->price}}</h4>

                                <label for="cate">Категория и подкатегория</label>
                                <h4 class="form-control" id='cate'>{{$product->category}}, {{$product->subcategory}}</h4>

                                <label for="count">Количество</label>
                                <h4 class="form-control" id='count'>{{$product->count}}</h4>
                                
                                <label for="color">Цвет</label>
                                <h4 class="form-control" id='color'>{{$product->color}}</h4>

                                <label for="seller">Продавец</label>
                                <h4 class="form-control" id='seller'>{{$product->seller}}</h4>

                                <label for="img">Фото</label><br>
                                @foreach ($gallery as $photo)
                                    <img src="/images/products/{{$photo->photo}}" alt="{{$photo->photo}}" style='width: 150px; height:150px; object-fit:cover;'>
                                @endforeach

                                <br><br>

                                <label for="desc">Описание</label>
                                <p style='border: 1px #c0c0c0 solid; padding: 5px; padding-left: 10px; padding-right: 10px; border-radius: 5px;' id='desc' >{{$product->description}}</p>

                                <label for="dop">Дополнительные характеристики</label>
                                
                                    @foreach ($dop_info as $item)
                                    <h4 class="form-control" id='dop'><b>{{$item->info}}: </b>{{$item->value}}</h4>
                                    @endforeach
                                    <br>


                                <label for="date">Дата подачи заявки</label>
                                <h4 class="form-control" id='date'>{{$product->created_at}}</h4>

                                <br>

                                <div style="display: flex; gap: 10px;">
                                    <form action="{{route('products.update', $product->id)}}" method="post" enctype="multipart/form-data">
                                        @method('PUT')
                                        @csrf
                                        <button class="btn btn-success btn-sm">Одобрить</button>
                                    </form>

                                    <form action="{{route('products.destroy', $product->id)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm delete-btn" type="submit">
                                            <i class="fas fa-trash"></i>
                                            Отказать
                                        </button>
                                    </form>
                                </div>


                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</section>




@endsection