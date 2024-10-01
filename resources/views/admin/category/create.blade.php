@extends('layouts.admin_layout')

@section('title', 'Создание катгеории')

@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Создание категории</h1>
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

<form action="{{route('categories.store')}}" method="post" enctype="multipart/form-data" id='form_required'>
@method('POST')
@csrf
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Название</label>
                                <input class="form-control required" id='name' name='name' placeholder='Название товара'>
                                <br>
                                <label for="description">Описание</label>
                                <textarea class="form-control required" id='description' name='description' placeholder='Описание товара'></textarea>
                                <br>
                                <label for="banner">Баннер на главной странице
                                <input type="checkbox" name="banner" id="banner"></label>
                                <br><br>
                                <label for="photo">Фото</label><br>
                                <label for="photo">
                                    <img id='changephoto' src="/images/main/photo.png" alt="photo" style='height: 150px'>
                                </label>
                                <input onchange="previewImage(event, 'changephoto')" id="photo" name='photo' type="file" class='required' style='display: none;'/>
                                <br><br>


                                <label for="photo_banner">Фото Баннера</label><br>
                                <label for="photo_banner">
                                    <img id='changebanner' src="/images/main/photo.png" alt="photo" style='height: 150px'>
                                </label>
                                <input onchange="previewImage(event, 'changebanner')" id="photo_banner" name='photo_banner' type="file" style='display: none;'/>

                                <br><br>

                                <button class="btn btn-success btn-sm" id='btn_required'>Сохранить</button>
                                <p class='text-danger'><i id='error_required'></i></p>

                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</section>
</form>


<script>

function previewImage(event, imgId) {
    var input = event.target;
    if (input.files && input.files[0]) {
        var file = input.files[0];
        var fileSize = file.size / 1024 / 1024; // Size in MB
        if (fileSize > 10) {
            alert("Файл должен весить менее 10 мб.");
            return;
        }
        if (!['image/jpeg', 'image/jpg', 'image/png', 'image/webp'].includes(file.type)) {
            alert("Допускаются только файлы с расширением .JPG, .JPEG, .PNG до 10 мб включительно");
            return;
        }
        const imgElement = document.getElementById(imgId);
        if (file) {
            imgElement.src = URL.createObjectURL(file);
            imgElement.classList.add("changephoto");
        }
    }
}


</script>

<script src="/admin/js/required.js" defer type="module"></script>

@endsection