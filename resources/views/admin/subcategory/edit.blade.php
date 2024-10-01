@extends('layouts.admin_layout')

@section('title', 'Просмотр подкатегории')

@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Подкатегория: {{$subcategory->name}}</h1>
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

<form action="{{route('subcategories.update', $subcategory->id)}}" method="post" enctype="multipart/form-data" id='form_required'>
@method('PUT')
@csrf
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Название</label>
                                <input class="form-control required" id='name' name='name' value='{{$subcategory->name}}'>
                                <br>
                                <label for="category">Категория</label>
                                <select name="category" id="category" class='form-control'>
                                    @foreach ($categories as $category)
                                        <option value="{{$category->id}}" @if($category->id==$subcategory->category_id) selected @endif>{{$category->name}}</option>
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