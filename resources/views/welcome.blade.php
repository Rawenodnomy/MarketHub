@include ('/layouts/header')
<div class="container-fluid mb-3">
        <div class="row px-xl-5">
            <div class="col-lg-8">
                <div id="header-carousel" class="carousel slide carousel-fade mb-30 mb-lg-0" data-ride="carousel">
                    <ol class="carousel-indicators">

                        @foreach ($banners as $banner)
                            <li data-target="#header-carousel" data-slide-to="{{$banner->num}}" @if ($banner->num==0) class="active" @endif></li>
                        @endforeach



                    </ol>
                    <div class="carousel-inner">
                        @foreach ($banners as $banner)
                            <div class="carousel-item position-relative @if ($banner->num==0) active @endif" style="height: 430px;">
                                <img class="position-absolute w-100 h-100" src="/images/categories/{{$banner->banner_photo}}" alt ='{{$banner->banner_photo}}' style="object-fit: cover;">
                                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                    <div class="p-3" style="max-width: 700px;">
                                        <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown">{{$banner->name}}</h1>
                                        <p class="mx-md-5 px-5 animate__animated animate__bounceIn">{{$banner->description}}</p>
                                        <a class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp" href="/catalog?category={{$banner->id}}">Перейти в каталог</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="product-offer mb-30" style="height: 200px;">
                    <img class="img-fluid" src="/images/main/i.webp" alt="i.webp">
                    <div class="offer-text">
                        <h6 class="text-white text-uppercase">Множество товаров</h6>
                        <h3 class="text-white mb-3">Каталог</h3>
                        <a href="/catalog" class="btn btn-primary">Перейти</a>
                    </div>
                </div>
                <div class="product-offer mb-30" style="height: 200px;">
                    <img class="img-fluid" src="/images/main/den.webp" alt="den.webp">
                    <div class="offer-text">
                        <h6 class="text-white text-uppercase">Разместите свои товары</h6>
                        <h3 class="text-white mb-3">Зарабатывать на MarketHub</h3>
                        <a href="/seller/createSeller" class="btn btn-primary">Перейти</a>
                    </div>
                </div>
            </div>
        </div>
    </div>











    <div class="container-fluid pt-5">
        <div class="row px-xl-5 pb-3">
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fa fa-check text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">Множество товаров</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fa fa-shipping-fast text-primary m-0 mr-2"></h1>
                    <h5 class="font-weight-semi-bold m-0">Бесплатная доставка</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fas fa-exchange-alt text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">14 дней на возврат</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fa fa-phone-volume text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">Круглосуточная поддержка</h5>
                </div>
            </div>
        </div>
    </div>









    <div class="container-fluid pt-5">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Категории</span></h2>
        <div class="row px-xl-5 pb-3">
            @foreach ($categories as $category)
                <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                    <a class="text-decoration-none" href="/catalog?category={{$category->id}}">
                        <div class="cat-item d-flex align-items-center mb-4">
                            <div class="overflow-hidden" style="width: 100px; height: 100px;">
                                <img class="img-fluid" src="/images/categories/{{$category->photo}}" alt="{{$category->photo}}">
                            </div>
                            <div class="flex-fill pl-3">
                                <h6>{{$category->name}}</h6>
                                <small class="text-body">{{$category->count}} Товаров</small>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>


































    <div class="container-fluid pt-5 pb-3">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Новые товары</span></h2>
        <div class="row px-xl-5">




            @foreach ($newProduct as $new)
                <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                    <div class="product-item bg-light mb-4">
                        <div class="product-img position-relative overflow-hidden">
                            <img class="img-fluid w-100" src="/images/products/{{$new->first_photo}}" alt="{{$new->first_photo}}">
                            <div class="product-action">
                                <a class="btn btn-outline-dark btn-square" href="/getProduct/{{$new->id}}"><i class="fa fa-search"></i></a>
                            </div>
                        </div>
                        <div class="text-center py-4">
                            <a class="h6 text-decoration-none text-truncate" href="/getProduct/{{$new->id}}">{{$new->name}}</a>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <h5>{{$new->price}} ₽</h5><h6 class="text-muted ml-2"><del>{{round($new->price*1.1)}} ₽</del></h6>
                            </div>
                            <div class="d-flex align-items-center justify-content-center mb-1">
                            @if ($new->rating!=0)  
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small>{{$new->rating}} ({{$new->review_count}} оценок)</small>
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




























    




    <div class="container-fluid pt-5 pb-3">
        <div class="row px-xl-5">
            <div class="col-md-6">
                <div class="product-offer mb-30" style="height: 300px;">
                    <img class="img-fluid" src="/images/main/car.webp" alt="">
                    <div class="offer-text">
                        <!-- <h6 class="text-white text-uppercase">Save 20%</h6> -->
                        <h3 class="text-white mb-3">Разместить свой товар</h3>
                        <a href="/seller/createSeller" class="btn btn-primary">Перейти</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="product-offer mb-30" style="height: 300px;">
                    <img class="img-fluid" src="/images/main/vop.webp" alt="">
                    <div class="offer-text">
                        <!-- <h6 class="text-white text-uppercase">Save 20%</h6> -->
                        <h3 class="text-white mb-3">Вопросы и ответы</h3>
                        <a href="/getQuestionsAndAnswers" class="btn btn-primary">Перейти</a>
                    </div>
                </div>
            </div>
        </div>
    </div>






<div class="container-fluid pt-5 pb-3">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Лучшие товары</span></h2>
        <div class="row px-xl-5">




            @foreach ($topProduct as $top)
                <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                    <div class="product-item bg-light mb-4">
                        <div class="product-img position-relative overflow-hidden">
                            <img class="img-fluid w-100" src="/images/products/{{$top->first_photo}}" alt="{{$top->first_photo}}">
                            <div class="product-action">
                                <a class="btn btn-outline-dark btn-square" href="/getProduct/{{$top->id}}"><i class="fa fa-search"></i></a>
                            </div>
                        </div>
                        <div class="text-center py-4">
                            <a class="h6 text-decoration-none text-truncate" href="/getProduct/{{$top->id}}">{{$top->name}}</a>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <h5>{{$top->price}} ₽</h5><h6 class="text-muted ml-2"><del>{{round($top->price*1.1)}} ₽</del></h6>
                            </div>
                            <div class="d-flex align-items-center justify-content-center mb-1">
                            @if ($top->rating!=0)  
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small>{{$top->rating}} ({{$top->review_count}} оценок)</small>
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


    <div class="container-fluid py-5">
    <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Лучшие продавцы</span></h2>
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel vendor-carousel">
                    @foreach ($topSellers as $seller)
                        <a href="/getSeller/{{$seller->id}}">
                            <div>
                                <div class="bg-light p-4">
                                    <img src="/images/sellers/{{$seller->photo}}" alt="{{$seller->photo}}" style='width: 200px; height: 200px; object-fit:cover; margin: auto;'>
                                </div>
                                <div class="bg-light p-4">
                                    <h6 style="text-align: center;">{{$seller->name}}</h6>
                                    <p style="text-align: center; color:black;">{{$seller->rating}} <small class="fas fa-star text-primary ml-1"></small></p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

<script src="/assets/lib/owlcarousel/assets/owl.carousel.min.js"></script>
<script  src="/assets/js/main.js"></script> 


@include ('/layouts/footer')



