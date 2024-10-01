@include ('/layouts/header')

<form action="/insertProduct" method="post" enctype="multipart/form-data" id='form_create'>
        @csrf
    <div class="container-fluid">
        <div class="row px-xl-5">

            
            <div class="col-lg-8" style="margin: auto;">
                
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Создать товар</span></h5>
                
                <div class="bg-light p-30 mb-5">
                    <div class="">
                        <div class="col-md-6 form-group" style="margin: auto;">
                            <label for="name">Название <span style="color: red;">*</span></label>
                            <input class="form-control required" id="name" type="text" name='name'>
                        </div>
                        <br>
                        <div class="col-md-6 form-group" style="margin: auto;">
                            <label for="price">Цена <span style="color: red;">*</span></label>
                            <input class="form-control required" type="number" name='price' id="price">

                        </div>
                        <br>
                        <div class="col-md-6 form-group" style="margin: auto;">
                            <label for="color">Цвет <span style="color: red;">*</span></label>
                            <select name="color" id="color" class="form-control required">
                                @foreach ($colors as $color)
                                    <option value="{{$color->id}}">{{$color->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <br>
                        <div class="col-md-6 form-group" style="margin: auto;">
                            <label for="category">Категория <span style="color: red;">*</span></label>
                            <select name="category" id="category" class="form-control required">
                                @foreach ($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <br>

                        <div class="col-md-6 form-group" id="sub_block" style="margin: auto;">

                        </div>
                        <br>

                        <div class="col-md-6 form-group" style="margin: auto;">
                            <label for="description">Описание <span style="color: red;">*</span></label>
                            <textarea class="form-control required" name="description" id=""></textarea>
                        </div>
                        <br>

                        <div class="col-md-6 form-group" id="count_block" style="margin: auto;">

                        </div>
                        <br>

                        <div class="col-md-6 form-group" style="margin: auto;">
                            <input class="required form-control" type="file" name="images[]" id="upload_img" multiple="multiple" >
                        </div>
                        <br>

                        <div class="col-md-6 form-group" style="margin: auto;">
                            <label for="dop">Дополнительные характеристики</label>
                            <input type="text" class='form-control' name='dop1' id='dop-1' data-dop='1' placeholder='Название характеристики'>
                            <input type="text" class='form-control' name='val1' id='val-1' data-dop='1' placeholder='Значение характеристики'>
                        <div>

                        <div id='block_for_dop'></div>


                        <button class='btn btn-primary' style='margin-top: 10px;' id='create_dop'>Добавить характеристики</button>



                        <br>
                        <p style="text-align: center;">
                            <button class="btn col-md-6 btn-primary font-weight-bold my-3 py-3" id="btn_form">Подать заявку</button>
                        </p>
                        <p id="required_box" style="color: red; text-align: center;"></p>
                    </div>
                </div>

            </div>
   
        </div>
    </div>

    </form>

<script src="/assets/js/create.js" defer type="module"></script>
@include ('/layouts/footer')