@include ('layouts/header')


    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <span class="breadcrumb-item active">Ваши товары</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->


    <!-- Cart Start -->
    <div class="container-fluid" >
        <div class="row px-xl-5" >
            <div class="col-lg-8 table-responsive mb-5" >
                <table class="table table-light table-borderless table-hover text-center mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th>Товар</th>
                            <th>Категория</th>
                            <th>Количество</th>
                            <th>Статус</th>
                            <th>Действие</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @foreach ($products as $product)
                            <tr>
                                <td class="align-middle" style='text-align: left; padding-left: 20px;'><img src="/images/products/{{$product->photo}}" alt="{{$product->photo}}" style="width: 50px; height: 50px; object-fit:cover"> {{$product->name}}</td>
                                <td class="align-middle">{{$product->category}} ({{$product->sub}})</td>
                                <td class="align-middle">
                                    {{$product->count}}
                                </td>
                                <td class="align-middle">{{$product->stage}}</td>
                                @if ($product->status_id==3 && $product->update == false)
                                    <td class="align-middle"><button class="btn btn-sm btn-primary generate" data-count='true' value='{{$product->id}}'>Обновить Количество</button></td>
                                @elseif ($product->status_id==1)
                                    <td class='align-middle'>После проверки, здесь появится код</td>
                                @elseif ($product->update==true)
                                    <td class="align-middle"><button class="btn btn-sm btn-primary generate" data-count='update' value='{{$product->id}}'>Сдать на склад (кол-во)</button></td>
                                @elseif ($product->status_id==2)
                                    <td class="align-middle"><button class="btn btn-sm btn-primary generate" data-count='false' value='{{$product->id}}'>Сдать на склад</button></td>
                                @else 
                                <td class="align-middle">Отказано</td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <div class="bg-light p-30 mb-5">
                    <div class="border-bottom pb-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h6 id='text_block'>Здесь будет важная информация</h6>
                        </div>
                        <div id='block'>
                            
                        </div>
                        <p id='qr-code' style='text-align:center;'></p>

                    </div>

                </div>
            </div>
        </div>
    </div>

    
@include ('layouts/footer')