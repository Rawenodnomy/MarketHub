@extends('layouts.admin_layout')

@section('title', 'Добавить работника')

@section('content')

<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Добавить работника</h1>
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

<form action="{{route('worker.store')}}" method="post" enctype="multipart/form-data" id='form_required'>
@method('POST')
@csrf
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">ФИО</label>
                                <input class="form-control required" id='name' name='name' placeholder='Введите ФИО'>
                                <br>
                                <label for="email">Почта</label>
                                <input class="form-control required" id='email' name='email' placeholder='Введите Почту'>
                                <br>
                                <label for="city">Город</label>
                                <select name="city" id="city" class='form-control'>
                                    @foreach ($cities as $city)
                                        <option value="{{$city->id}}">{{$city->name}}</option>
                                    @endforeach
                                </select>
                                <br>
                                <label for="address">Пункт выдачи</label>
                                <select name="address" id="address" class='form-control'>

                                </select>
                                <br>
                                <button class="btn btn-cyan btn-sm mb-3" id='gen_password' style='background-color: #17a2b8; color: white;'>Сгенирировать пароль</button>
                                <input type="text" name="password" id="password" class='form-control required' readonly>
                                
                                <br>
                                <button class="btn btn-success btn-sm" id='btn_required'>Добавить</button>
                                <p class='text-danger'><i id='error_required'></i></p>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</section>
</form>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<script src="/admin/js/required.js" defer type="module"></script>
<script src="/admin/js/worker.js" defer type="module"></script>
@endsection