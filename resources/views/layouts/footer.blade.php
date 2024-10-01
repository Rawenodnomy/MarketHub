<?php
    $infoblocks = DB::select('SELECT * FROM infoblocks');
?>

<div class="container-fluid bg-dark text-secondary mt-5 pt-5">
        <div class="row px-xl-5 pt-5">
            <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
                <h5 class="text-secondary text-uppercase mb-4">MarketHub</h5>
                <p class="mb-4">Добро пожаловать на MarketHub! Откройте для себя уникальные товары по выгодным ценам. У нас широкий ассортимент, быстрая доставка и удобный интерфейс. Покупайте с удовольствием и находите лучшее с MarketHub!</p>
                <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>Город Екатеринбург, ул. Фурманова 106</p>
                <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>MarketHub@gmail.com</p>
                <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>+7 (908)-064-46-70</p>
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="row">
                    <div class="col-md-4 mb-5">
                        <h5 class="text-secondary text-uppercase mb-4">Меню</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-secondary mb-2" href="/"><i class="fa fa-angle-right mr-2"></i>Главная</a>
                            <a class="text-secondary mb-2" href="/catalog"><i class="fa fa-angle-right mr-2"></i>Каталог</a>
                            <a class="text-secondary mb-2" href="/getUserBasket"><i class="fa fa-angle-right mr-2"></i>Корзина</a>
                            <a class="text-secondary mb-2" href="/getFavoriteByUser"><i class="fa fa-angle-right mr-2"></i>Избранное</a>
                            <a class="text-secondary mb-2" href="{{ url('/home') }}"><i class="fa fa-angle-right mr-2"></i>Профиль</a>
                            <a class="text-secondary" href="/seller/createSeller"><i class="fa fa-angle-right mr-2"></i>Кабинет продавца</a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <h5 class="text-secondary text-uppercase mb-4">Информация</h5>
                        <div class="d-flex flex-column justify-content-start">
                            @foreach ($infoblocks as $info)
                                <a class="text-secondary mb-2" href="/getInfoblock/{{$info->id}}"><i class="fa fa-angle-right mr-2"></i>{{$info->title}}</a>
                            @endforeach
                            <a class="text-secondary mb-2" href="/getQuestionsAndAnswers"><i class="fa fa-angle-right mr-2"></i>Вопросы-ответы</a>
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-5">
                        <h5 class="text-secondary text-uppercase mb-4">Зарегистрируйтесь</h5>
                        <p>И совершайте покупки уже сейчас</p>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Пройти регистрацию" readonly>
                            <div class="input-group-append">
                                <a href="/register" class="btn btn-primary">Пройти</a>
                            </div>
                        </div>
                        <h6 class="text-secondary text-uppercase mt-4 mb-3">Наши социальные сети</h6>
                        <div class="d-flex">
                            <a class="btn btn-primary btn-square mr-2" href="https://vk.com/rawenodnomy"><i class="fab fa-vk"></i></a>
                            <a class="btn btn-primary btn-square mr-2" href="https://t.me/rawenodnomy"><i class="fab fa-telegram"></i></a>
                            <a class="btn btn-primary btn-square" href="https://www.instagram.com/rawenodnomy"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row border-top mx-xl-5 py-4" style="border-color: rgba(256, 256, 256, .1) !important;">
            <div class="col-md-6 px-xl-0">
                <p class="mb-md-0 text-center text-md-left text-secondary">
                    &copy; <a class="text-primary" href="/">MarketHub</a>. 2024
                </p>
            </div>
        </div>
    </div>

    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>


<script src="/assets/lib/easing/easing.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.qrcode/1.0/jquery.qrcode.min.js"></script>
<script src="/assets/js/sellerProducts.js" defer type="module"></script>

</body>
</html>