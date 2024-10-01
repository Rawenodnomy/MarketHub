@extends('layouts.admin_layout')

@section('title', 'Просмотр Продавца')

@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Продавец: {{$seller->name}}</h1>
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
                                <label for="name">Название на площадке</label>
                                <h4 class="form-control" id='name'>{{$seller->name}}</h4>

                                <label for="price">Тип</label>
                                <h4 class="form-control" id='price'>{{$seller->org}}</h4>

                                <label for="cate">Название организации</label>
                                <h4 class="form-control" id='cate'>{{$seller->organization}}</h4>

                                <label for="cate">Инн</label>
                                <h4 class="form-control" id='cate'>{{$seller->inn}}</h4>

                                <label for="cate">Рег. номер</label>
                                <h4 class="form-control" id='cate'>{{$seller->registration_number}}</h4>

                                <label for="cate">Страна</label>
                                <h4 class="form-control" id='cate'>{{$seller->country}}</h4>

                                @if ($seller->legal_address != null)
                                    <label for="cate">Юр. адрес</label>
                                    <h4 class="form-control" id='cate'>{{$seller->legal_address}}</h4>
                                @endif


                                @if ($seller->kpp != null)
                                    <label for="cate">КПП</label>
                                    <h4 class="form-control" id='cate'>{{$seller->kpp}}</h4>
                                @endif


                                <label for="cate">ОГРН/ОГРНИП</label>
                                <h4 class="form-control" id='cate'>{{$seller->ogrn}}</h4>

                                <label for="cate">Пользователь</label>
                                <h4 class="form-control" id='cate'>{{$seller->user_name}} ({{$seller->user_email}})</h4>


                                <label for="img">Фото</label><br>
                                
                                <img src="/images/sellers/{{$seller->photo}}" alt="{{$seller->photo}}" style='width: 150px; height:150px; object-fit:cover;'>

                                <br><br>

                                <label for="desc">Описание</label>
                                <p style='border: 1px #c0c0c0 solid; padding: 5px; padding-left: 10px; padding-right: 10px; border-radius: 5px;' id='desc' >{{$seller->description}}</p>

                                <br>

                                <div style="display: flex; gap: 10px;">
                                    <form action="{{route('sellers.update', $seller->id)}}" method="post" enctype="multipart/form-data">
                                        @method('PUT')
                                        @csrf
                                        <button class="btn btn-success btn-sm">Одобрить</button>
                                    </form>

                                    <form action="{{route('sellers.destroy', $seller->id)}}" method="post">
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