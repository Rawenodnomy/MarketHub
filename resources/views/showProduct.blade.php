@include ('/layouts/header')

<div class="container-fluid pb-5">
        <div class="row px-xl-5">
            <div class="col-lg-5 mb-30">
                <div id="product-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner bg-light">
                        @foreach ($gallery as $photo)
                            <div class="carousel-item @if ($photo->active==true) active @endif">
                                <img class="w-100 h-100" src="/images/products/{{$photo->photo}}" alt="{{$photo->photo}}">
                            </div>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#product-carousel" data-slide="prev">
                        <i class="fa fa-2x fa-angle-left text-dark"></i>
                    </a>
                    <a class="carousel-control-next" href="#product-carousel" data-slide="next">
                        <i class="fa fa-2x fa-angle-right text-dark"></i>
                    </a>
                </div>
            </div>
            <input type="hidden" id='product_id' name="product_id" value='{{$product->id}}'>
            <input type="hidden" id='user_id' data-name='{{Auth::user()->name ?? null}}' name="user_id" value='{{Auth::user()->id ?? null}}'>
            <div class="col-lg-7 h-auto mb-30">
                <div class="h-100 bg-light p-30">
                    <h3>{{$product->name}}</h3>
                    <div class="d-flex mb-3">
                        <div class="text-primary mr-2">
                            <small style="color: black; font-size: 120%;" id='product_rating'>{{$product->rating}}</small>
                            <small class="fas fa-star"></small>
                        </div>
                        <small class="pt-1">(<span class='count_reviews' data-count='{{count($reviews)}}'>{{count($reviews)}}</span> оценок)</small>
                    </div>
                    <input type="hidden" name="in_basket" id='in_basket' value='@if ($inBasket!=[]) true @else false @endif'>
                    <h3 class="font-weight-semi-bold mb-4">{{$product->price}} ₽</h3>
                    <!-- <p class="mb-4">{{$product->description}}</p> -->
                    <p>Продавец: <a href="/getSeller/{{$product->seller_id}}" style='color:black; text-decoration: underline;'>{{$product->seller}}</a></p>
                    <p>Категория: <a href="/catalog?category={{$product->category_id}}" style='color:black; text-decoration: underline;'>{{$product->category}}</a></p>
                    <p>Подкатегория: 
                    <a href="/catalog?category={{$product->category_id}}&sub={{$product->subcategory_id}}" style='color:black; text-decoration: underline;'>{{$product->sub}}</a></p>
                    <p>Цвет: {{$product->color}}</p>
                    <p>Артикул: {{$product->article}}</p>
                    @if ($sizes !=[])
                    <div class="d-flex mb-4">
                        <strong class="text-dark mr-3">Размер:</strong>
                        @foreach ($sizes as $size)
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="size_{{$size->size}}" name="sizes" value="{{$size->size_id}}" {{ $loop->first ? 'checked' : '' }}>
                                <label class="custom-control-label" for="size_{{$size->size}}">{{$size->size}}</label>
                            </div>
                        @endforeach
                    </div>
                    @endif
                    @if (Auth::user())
                    <div class="d-flex align-items-center mb-4 pt-2 ">
                        <div class='counter_container'>
                        @if ($inBasket!=[])
                        <div class="input-group quantity mr-3 counter" style="width: 130px;" id='boxcounter'>
                            <div class="input-group-btn">
                                <button class="btn btn-primary btn-minus" id="decrement">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                            <input type="text" class="form-control bg-secondary border-0 text-center" id='number' value="{{$inBasket[0]->count}}" readonly>
                            <div class="input-group-btn">
                                <button class="btn btn-primary btn-plus" id="increment">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        @else
                        <button class="btn btn-primary px-3" id='basket'><i class="fa fa-shopping-cart mr-1"></i>В корзину</button>
                        @endif
                        </div>
                        <div id='fav_btn' style='margin-left: 20px; font-size: 150%; cursor:pointer;'>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="row px-xl-5">
            <div class="col">
                <div class="bg-light p-30">
                    <div class="nav nav-tabs mb-4">
                        <a class="nav-item nav-link text-dark active" data-toggle="tab" href="#tab-pane-1">Основная Информация</a>
                        <a class="nav-item nav-link text-dark" data-toggle="tab" href="#tab-pane-2">Доп. Информация</a>
                        <a class="nav-item nav-link text-dark" data-toggle="tab" href="#tab-pane-3">Отзывы (<span class='count_reviews' data-count='{{count($reviews)}}'>{{count($reviews)}}</span>)</a>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="tab-pane-1">
                            <h4 class="mb-3">Описание</h4>
                            <p>{{$product->description}}</p>
                        </div>
                        <div class="tab-pane fade" id="tab-pane-2">
                            <h4 class="mb-3">Дополнительная Информация</h4>
                            <p>Здесь представлена Дополнительная Информация от продавца, которая может повлиять на выбор товара.</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="list-group list-group-flush">

                                    @if ($information !=[])
                                    @foreach ($information as $info)
                                    @if ($info->column==1)
                                        <li class="list-group-item px-0">
                                            <b>{{$info->info}}:</b> {{$info->value}}
                                        </li>
                                        @endif
                                        @endforeach
                                        @endif
                                      </ul> 
                                </div>
                                <div class="col-md-6">
                                    
                                <ul class="list-group list-group-flush">

                                @if ($information !=[])
                                @foreach ($information as $info)
                                @if ($info->column==2)
                                    <li class="list-group-item px-0">
                                        <b>{{$info->info}}:</b> {{$info->value}}
                                    </li>
                                    @endif
                                    @endforeach
                                    <li class="list-group-item px-0">
                                        <b>Цвет: </b> {{$product->color}}
                                    </li>
                                    @endif
                                </ul> 
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab-pane-3">
                            <div class="row">
                                <div class="col-md-6" id="review_conrainer">
                                @foreach ($reviews as $review)
                                 
                                    <div class="media mb-1 mt-1" style='border-bottom: 1px #00000017 solid'  id='review_by_{{$review->user_id}}'>
                                        <div class="media-body">
                                            <h6>{{$review->user_name}}<small> - <small style="color: black; font-size: 150%;" id='product_rating'>{{$review->estimation}}</small><i class="fas fa-star text-primary ml-1" style='font-size: 120%;'></i></i></small></h6>
                                            <p>{{$review->content}} <i style='font-size:70%;'> <br> {{$review->created_at}}</i></p>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @if (Auth::user())
                                <div class="col-md-6" id="create_review">
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid py-5">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Вам может понравится</span></h2>
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel related-carousel">
                @foreach ($likeProducts as $like)
                    <div class="product-item bg-light">
                        <div class="product-img position-relative overflow-hidden">
                            <img class="img-fluid w-100" src="/images/products/{{$like->photo}}" alt="">
                            <div class="product-action">
                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i class="far fa-heart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-sync-alt"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-search"></i></a>
                            </div>
                        </div>
                        <div class="text-center py-4">
                            <a class="h6 text-decoration-none text-truncate" href="">{{$like->name}}</a>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <h5>{{$like->price}} ₽</h5><h6 class="text-muted ml-2"><del>{{round($like->price*1.1)}} ₽</del></h6>
                            </div>
                            <div class="d-flex align-items-center justify-content-center mb-1">
                                @if ($like->count_review!=0)
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class='mr-1'>{{$like->rating}}</small>
                                    <small>({{$like->count_review}})</small>
                                @else
                                    <small>Еще нет отзывов</small>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
        </div>
    </div>
<script>
    function updateStars(rating) {
        const stars = document.querySelectorAll('.star');
        stars.forEach((star, index) => {
            if (index < rating) {
                star.classList.remove('far');
                star.classList.add('fas');
                star.classList.add('text-primary');
            } else {
                star.classList.remove('fas');
                star.classList.add('far');
                star.classList.remove('text-primary');
            }
        });
    }
</script>

<script src="/assets/js/favorite.js" defer type="module"></script>
<script src="/assets/js/basket.js" defer type="module"></script>
<script src="/assets/js/review.js" defer type="module"></script>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

<script src="/assets/lib/owlcarousel/assets/owl.carousel.min.js"></script>
<script  src="/assets/js/main.js"></script> 

@include ('/layouts/footer')
