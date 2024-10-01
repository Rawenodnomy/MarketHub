@include ('/layouts/header')

<input type="hidden" id='user_id' name="user_id" value='{{Auth::user()->id ?? null}}'>
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <span class="breadcrumb-item active">Страница продавца</span>
                </nav>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
            <div class="col-lg-3 col-md-4">
                <!-- Price Start -->
                <div class="bg-light p-4 mb-30">
                    <div class="custom-control custom-checkbox align-items-center justify-content-between">
                            <p style="text-align: center;">
                            <img src="/images/sellers/{{$seller->photo}}" alt="{{$seller->photo}}" style="width: 200px; height: 200px; object-fit: cover; margin-right: 20px;">
                            <br>
                            <h3 class="mt-3" style="text-align: center;">{{$seller->name}}</h3>
                            <p style="text-align: center;">{{$seller->rating}} <small class="fas fa-star text-primary ml-1"></small></p>
                            <p style="text-align: justify;">{{$seller->description}}</p>
                            </p>
                    </div>
                </div>
                <div class="bg-light p-4 mb-30">
                    <div class="custom-control custom-checkbox align-items-center justify-content-between">
                        <p style="text-align: center;">Информация о продавце</p>
                        <p><b>Организация:</b> {{$seller->type}} - {{$seller->organization}}</p>
                        <hr>
                        <p><b>Тип Организации:</b> {{$seller->reduction}} ({{$seller->type}})</p>
                        <hr>
                        <p><b>Регистрационный номер:</b> {{$seller->registration_number}}</p>
                        <hr>
                        <p>ОГРН @if ($seller->organization_type_id==2) {{$seller->reduction}} @endif:</b> {{$seller->ogrn}}</p>
                        <hr>
                        <p><b>ИНН:</b>  {{$seller->inn}}</p>
                        <hr>
                        <p><b>Страна:</b> {{$seller->country}}</p>
                        <hr>
                        @if ($seller->organization_type_id!=2)
                            <p><b>Юридический адрес:</b> {{$seller->legal_address}}</p>
                            <hr>
                            <p><b>КПП:</b> {{$seller->kpp}}</p>
                            <hr>
                        @endif
                    </div></div>
            </div>
            <div class="col-lg-9 col-md-8">
                <div class="row pb-3">
                    <div class="col-12 pb-1">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>
                                
                            </div>
                            <div class="ml-2">
                                    
                            <select name="sort" id="sort" class='form-control' >
                                <option value="default desc">По умолчанию</option>
                                <option value="created_at desc">По новизне</option>
                                <option value="rating desc">По рейтингу</option>
                                <option value="price asc">Дешевле</option>
                                <option value="price desc">Дороже</option>
                            </select>

                            </div>
                        </div>
                    </div>






                    <div id='catalog' class="d-flex flex-wrap">
                    @foreach ($products as $product)
                    <div class="col-lg-4 col-md-6 col-sm-6 pb-1 item" id='{{$product->id}}'>
                        <div class="product-item bg-light mb-4">
                            <div class="product-img position-relative overflow-hidden">
                                <img class="img-fluid w-100" src="/images/products/{{$product->photo}}" alt="{{$product->photo}}">
                                <div class="product-action">
                                    @Auth
                                        <a class="btn btn-outline-dark btn-square fav_btns" data-id='{{$product->id}}'><i class="@if ($product->fav==true) fa @else far @endif fa-heart" id="fav_block_{{$product->id}}"></i></a>
                                    @endauth
                                    <!-- <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-sync-alt"></i></a> -->
                                    <a class="btn btn-outline-dark btn-square" href="/getProduct/{{$product->id}}"><i class="fa fa-search"></i></a>
                                </div>
                            </div>
                            <div class="text-center py-4">
                                <a class="h6 text-decoration-none text-truncate" href="/getProduct/{{$product->id}}">{{$product->name}}</a>
                                <div class="d-flex align-items-center justify-content-center mt-2">
                                    <h5>{{$product->price}} ₽</h5><h6 class="text-muted ml-2"><del>{{round($product->price*1.1)}} ₽</del></h6>
                                </div>
                                <div class="d-flex align-items-center justify-content-center mb-1">
                                    @if ($product->rating!=0)  
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class='mr-1'>{{$product->rating}}</small>
                                    <small>({{$product->count_review}})</small>
                                    @else
                                    <small>Еще нет отзывов</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    </div>




                </div>
            </div>

        </div>
    </div>



    <script src="/assets/js/catalogSeller.js" defer type="module"></script>


@include ('/layouts/footer')