@extends('layouts.admin_layout')

@section('title', 'Добавить пункт выдачи')

@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Добавить пункт выдачи</h1>
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

<form action="{{route('point.store')}}" method="post" enctype="multipart/form-data" id='form_required'>
@method('POST')
@csrf
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="address">Название</label>
                                <input class="form-control required" id='address' name='address' >
                                <br>
                                <label for="city">Город</label>
                                <select name="city" id="city" class='form-control'>
                                    @foreach ($cities as $city)
                                        <option value="{{$city->id}}">{{$city->name}}</option>
                                    @endforeach
                                </select>
                                
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
<script src="/admin/js/required.js" defer type="module"></script>

@endsection