@extends('layouts.admin_layout')

@section('title', 'Просмотр пункта')

@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Пункт: {{$point->address}}</h1>
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

<form action="{{route('point.update', $point->id)}}" method="post" enctype="multipart/form-data" id='form_required'>
@method('PUT')
@csrf
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="address">Название</label>
                                <input class="form-control required" id='address' name='address' value='{{$point->address}}'>
                                <br>
                                <label for="city">Город</label>
                                <select name="city" id="city" class='form-control'>
                                    @foreach ($cities as $city)
                                        <option value="{{$city->id}}" @if($city->id==$point->city_id) selected @endif>{{$city->name}}</option>
                                    @endforeach
                                </select>
                                
                                <br>
                                <button class="btn btn-success btn-sm" id='btn_required'>Обновить</button>
                                <p class='text-danger'><i id='error_required'></i></p>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</section>
</form>
<script src="/admin/js/required.js" defer type="module"></script>

@endsection