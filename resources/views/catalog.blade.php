@include ('/layouts/header')



<input type="hidden" id='user_id' name="user_id" value='{{Auth::user()->id ?? null}}'>


    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="#">Каталог</a>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->


    <!-- Shop Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
            <div class="col-lg-3 col-md-4">
                <!-- Price Start -->
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Фильтрация</span></h5>
                <div class="bg-light p-4 mb-30">

 
                @foreach ($categories as $category)
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input checkbox_category" id="check_{{$category->name}}" name='check_{{$category->name}}' value='{{$category->id}}'>
                        <label class="custom-control-label" for="check_{{$category->name}}">{{$category->name}}</label>
                        <span class="badge border font-weight-normal" style='color:gray;'>{{$category->count}}</span>
                    </div>
                @endforeach

                <button class="btn btn-primary px-3" id="showSelected">Найти</button>
                <button id="clearFiltr" class="btn px-3" style='background-color: black; color:white; border: 0px;'>Сбросить</button>

                </div>
                <!-- Price End -->
                

            
            <!-- Shop Sidebar End -->

            <div id="subcategory">


            </div>
            </div>

            <!-- Shop Product Start -->
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
                    <div class="col-lg-4 col-md-6 col-sm-6 pb-1 item" id='{{$product->id}}' data-cate_id='{{$product->category_id}}' data-sub_id='{{$product->subcategory_id}}'>
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
            <!-- Shop Product End -->
        </div>
    </div>
    <!-- Shop End -->












<script src="/assets/js/catalog.js" defer type="module"></script>

@include ('/layouts/footer')