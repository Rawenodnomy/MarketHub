@include ('/layouts/header')


@if ($seller==[])

<form method="POST" action="/insertSeller" method="post" enctype="multipart/form-data" id='form_seller_create'>
        @csrf

    <div class="container-fluid">
        <div class="row px-xl-5">

            
            <div class="col-lg-8" style="margin: auto;">
                
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Стать продавцом</span></h5>
                
                <div class="bg-light p-30 mb-5">
                    <div class="">
                        <div class="col-md-6 form-group" style="margin: auto;">
                            <label for="type">Тип <span class="text-danger">*</span></label>

                            <select class="form-control" name="type" id="type">
                                @foreach ($types as $type)
                                    <option value="{{$type->id}}">{{$type->type}}</option>
                                @endforeach
                            </select>
 
                        </div>
                        
                        <br>

                        <div class="col-md-6 form-group" style="margin: auto;">
                            <label for="name">Название на площадке <span class="text-danger">*</span></label>

                            <input type="text" id='name' name='name' class='required form-control'>
 
                            <p class='errors text-danger' id='name_error'></p>

                        </div>

                        <br>

                        <div class="col-md-6 form-group" style="margin: auto;" id="organization">

                        </div>

                        <br>

                        <div class="col-md-6 form-group" style="margin: auto;">
                            <label for="inn">ИНН и Регистрационный номер <span class="text-danger">*</span></label>
                            <input type="number" name="inn" id="inn_value" class='required form-control'>
                            <p class='errors text-danger' id='inn_error'></p>
                        </div>

                        <br>

                        <div class="col-md-6 form-group" style="margin: auto;">
                            <label for="country">Страна <span class="text-danger">*</span></label>
                            <input type="text" name="country" id="country" class='required form-control'>
                        </div>

                        <br>

                        <div class="col-md-6 form-group" style="margin: auto;" id="address">
                            
                        </div>

                        <br>

                        <div class="col-md-6 form-group" style="margin: auto;" id="kpp">
                            
                        </div>

                        <br>

                        <div class="col-md-6 form-group" style="margin: auto;">
                            <label for="ogrn_value" id="ogrn">ОГРН <span class="text-danger">*</span></label>
                            <input type="number" name="ogrn" id="ogrn_value" class='required form-control'>
                            <p class='errors text-danger' id='ogrn_error'></p>
                        </div>

                        <br>

                        <div class="col-md-6 form-group" style="margin: auto;">
                            <label for="logo">Логотип <span class="text-danger">*</span></label>
                            <input type="file" name="logo" id="logo" class='required form-control'>
                        </div>

                        <br>

                        <div class="col-md-6 form-group" style="margin: auto;">
                            <label for="description">Описание <span class="text-danger">*</span></label>
                            <textarea name="description" id="description" class='required form-control'></textarea>
                        </div>



                        <br>
                        <p style="text-align: center;">
                            <button class="btn col-md-6 btn-primary font-weight-bold my-3 py-3" id='btn_seller_create'>Отправить заявку</button>
                            <p class='errors text-danger' id='required' style='text-align: center;'></p>
                        </p>
                    </div>
                </div>

            </div>
   
        </div>
    </div>
</form>

<script src="/assets/js/sellerCreate.js" defer type="module"></script>

@else 
<h6 style='text-align: center; margin-top: 150px;'>Ваша заявка отправлена на рассмотрение</h6>
<p style='text-align: center; margin-bottom: 150px;'>
    <a href="/" class="btn btn-primary font-weight-bold my-3 py-3">Вернуться на главную страницу</a>
</p>
@endif

@include ('/layouts/footer')