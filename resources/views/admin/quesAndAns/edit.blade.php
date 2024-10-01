@extends('layouts.admin_layout')

@section('title', 'Редактировать Вопрос и Ответ')

@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Редактировать Вопрос и Ответ №{{$quesAndAns->id}}</h1>
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

<form action="{{route('questAndAns.update', $quesAndAns->id)}}" method="post" enctype="multipart/form-data"  id='form_required'>
@method('PUT')
@csrf
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="que">Вопрос</label>
                                <input class="form-control required" id='que' name='que' value='{{$quesAndAns->questions}}'>
                                <br>
                                <label for="ans">Ответ</label>
                                <textarea name="ans" id="ans" value='{{$quesAndAns->answers}}' class='form-control required'>{{$quesAndAns->answers}}</textarea>
                                
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