<?php
    $categories = DB::select('SELECT *, (SELECT COUNT(*) FROM products WHERE products.category_id = categories.id) as count FROM categories');
    $subcategories = DB::select('SELECT * FROM `subcategories` ');
    $infoblocks = DB::select('SELECT * FROM infoblocks');
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>MarketHub - Маркетплейс</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="MarketHub" name="keywords">
    <meta content="MarketHub - интернет магазин со множеством товаров" name="description">
    <meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">  

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">


    <link href="/assets/lib/animate/animate.min.css" rel="stylesheet">
    <link href="/assets/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="/assets/css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Topbar Start -->
    <div class="container-fluid">
        <div class="row bg-secondary py-1 px-xl-5">
            <div class="col-lg-6 d-none d-lg-block">
                <div class="d-inline-flex align-items-center h-100">
                    @foreach ($infoblocks as $item)
                        <a class="text-body mr-3" href="/getInfoblock/{{$item->id}}">{{$item->title}}</a>
                    @endforeach
                    <a class="text-body mr-3" href="/getQuestionsAndAnswers">Вопросы-ответы</a>
                </div>
            </div>
            <div class="col-lg-6 text-center text-lg-right">
                <div class="d-inline-flex align-items-center">
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">Мой Аккаунт</button>
                        <div class="dropdown-menu dropdown-menu-right">
                            @if (Route::has('login'))
                                <div>
                                    @auth
                                    <a href="{{ url('/home') }}" class="dropdown-item">{{ Auth::user()->name }}</a>

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Выйти') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>

                                    @else
                                        <a href="{{ route('login') }}" class="dropdown-item">Войти</a>
                                        @if (Route::has('register'))
                                            <a href="{{ route('register') }}" class="dropdown-item">Регистрация</a>
                                        @endif
                                    @endauth
                                </div>
                            @endif
                        </div>
                    </div>
                    <!-- <div class="btn-group mx-2">
                        <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">USD</button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <button class="dropdown-item" type="button">EUR</button>
                            <button class="dropdown-item" type="button">GBP</button>
                            <button class="dropdown-item" type="button">CAD</button>
                        </div>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">EN</button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <button class="dropdown-item" type="button">FR</button>
                            <button class="dropdown-item" type="button">AR</button>
                            <button class="dropdown-item" type="button">RU</button>
                        </div>
                    </div> -->
                </div>
                @auth
                <?php
                    $countBasket = DB::select('SELECT SUM(count) as count FROM `baskets` WHERE user_id = ?', [Auth::user()->id])[0]->count;
                    $countFav = DB::select('SELECT COUNT(*) as count FROM `favourites` WHERE user_id =  ?', [Auth::user()->id])[0]->count;
                ?>
                <div class="d-inline-flex align-items-center d-block d-lg-none">
                    <a href="/getFavoriteByUser" class="btn px-0 ml-2">
                        <i class="fas fa-heart text-dark"></i>
                        <span class="badge text-dark border border-dark rounded-circle countFav" style="padding-bottom: 2px; ">{{$countFav}}</span>
                    </a>
                    <a href="/getUserBasket" class="btn px-0 ml-2">
                        <i class="fas fa-shopping-cart text-dark"></i>
                        <span class="badge text-dark border border-dark rounded-circle countBasket" style="padding-bottom: 2px;">@if ($countBasket!=null) {{$countBasket}} @else 0 @endif</span>
                    </a>
                </div>
                @endauth
            </div>
        </div>
        <div class="row align-items-center bg-light py-3 px-xl-5 d-none d-lg-flex">
            <div class="col-lg-4">
                <a href="/" class="text-decoration-none">
                    <span class="h1 text-uppercase text-primary bg-dark px-2">MARKET</span>
                    <span class="h1 text-uppercase text-dark bg-primary px-2 ml-n1">HUB</span>
                </a>
            </div>
            <div class="col-lg-4 col-6 text-left">
            </div>
            <div class="col-lg-4 col-6 text-right">
                <p class="m-0">Горячая линия</p>
                <h5 class="m-0">+7 (908)-064-46-70</h5>
            </div>
        </div>
    </div>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <div class="container-fluid bg-dark mb-30">
        <div class="row px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a class="btn d-flex align-items-center justify-content-between bg-primary w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; padding: 0 30px;">
                    <h6 class="text-dark m-0"><i class="fa fa-bars mr-2"></i>Категории</h6>
                    <i class="fa fa-angle-down text-dark"></i>
                </a>
                <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 bg-light" id="navbar-vertical" style="width: calc(100% - 30px); z-index: 999;">
                    <div class="navbar-nav w-100">




                        @foreach ($categories as $category)
                            <div class="nav-item dropdown dropright">
                                <a href="/catalog?category={{$category->id}}" class="nav-link dropdown-toggle" data-toggle="dropdown">{{$category->name}} <i class="fa fa-angle-right float-right mt-1"></i></a>
                                <div class="dropdown-menu position-absolute rounded-0 border-0 m-0">
                                    @foreach ($subcategories as $sub)
                                        @if ($sub->category_id==$category->id)
                                            <a href="/catalog?category={{$category->id}}&sub={{$sub->id}}" class="dropdown-item" style='border:1px #f7f7f7 solid;'>{{$sub->name}}</a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endforeach







                    </div>
                </nav>
            </div>
            <div class="col-lg-9">
                <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3 py-lg-0 px-0">
                    <a href="/" class="text-decoration-none d-block d-lg-none">
                        <span class="h1 text-uppercase text-dark bg-light px-2">Market</span>
                        <span class="h1 text-uppercase text-light bg-primary px-2 ml-n1">Hub</span>
                    </a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <a href="/" class="nav-item nav-link active">Главная</a>
                            <a href="/catalog" class="nav-item nav-link">Каталог</a>
                            @if (Auth::user())
                            <?php 
                                $seller = DB::select('SELECT * FROM `sellers` WHERE user_id=? AND approved=1', [Auth::user()->id]);
                            ?>
                            <a href="/getUserBasket" class="nav-item nav-link">Корзина</a>
                            @if ($seller!=[])
                            <a href="/seller/createSeller" class="nav-item nav-link">Кабинет продавца</a>
                            @endif
                            @endif
                        </div>
                        @auth
                        <div class="navbar-nav ml-auto py-0 d-none d-lg-block">
                            <a href="/getFavoriteByUser" class="btn px-0">
                                <i class="fas fa-heart text-primary"></i>
                                <span class="badge text-secondary border border-secondary rounded-circle countFav" style="padding-bottom: 2px;">{{$countFav}}</span>
                            </a>
                            <a href="/getUserBasket" class="btn px-0 ml-3">
                                <i class="fas fa-shopping-cart text-primary"></i>
                                <span class="badge text-secondary border border-secondary rounded-circle countBasket" style="padding-bottom: 2px;">@if ($countBasket!=null) {{$countBasket}} @else 0 @endif</span>
                            </a>
                        </div>
                        @endif
                        <div class="col-lg-4 col-6 text-left position-relative">


                        <form id='search-form'>
                            <div class="input-group">
                                <input type="text" class="form-control" id='search-input' placeholder="Найти товар" >
                                <div class="input-group-append">
                                    <span class="input-group-text bg-transparent text-primary" id='search-btn'>
                                        <i class="fa fa-search"></i>
                                    </span>
                                </div>
                            </div>
                        </form>


    <div id="search-results" class="mt-2 position-absolute w-100" style="display: none; z-index: 999;">



    </div>
</div>

                    </div>
                </nav>
            </div>
        </div>
    </div>
    <!-- Navbar End -->

<script src="/assets/js/search.js" defer type="module"></script>