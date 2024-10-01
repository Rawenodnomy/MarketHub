@include ('/layouts/header')

    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <span class="breadcrumb-item active">Корзина</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->


    <!-- Cart Start -->
    <div class="container-fluid" id='main_block'>
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th>Товар</th>
                            <th>Цена</th>
                            <th>Количество</th>
                            <th>Итог</th>
                            <th>Удалить</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle" id="baskets_items">

                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Cart Summary</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="border-bottom pb-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Итоговая сумма</h6>
                            <h6 id='total_sum' data-sum=''></h6>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <h6 class="font-weight-medium">Всего товаров</h6>
                            <h6 class="font-weight-medium" id='total_count'></h6>
                        </div>
                        <div class="city_block mb-3">
                            <select class="form-control" id="city">

                            </select>
                        </div>
                        <div class="mb-3">
                            <select class="form-control" id="address"></select>
                        </div>

                    </div>
                    
                    <div class="pt-2" id='order_button'>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>








<script src="/assets/js/basketPage.js" defer type="module"></script>
@include ('/layouts/footer')