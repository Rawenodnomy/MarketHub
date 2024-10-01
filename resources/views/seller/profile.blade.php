@include ('/layouts/header')






<div class="container-fluid pb-5 mt-30">
    <div class="row px-xl-5 mb-30">
        <div class="col-lg-7 h-auto mb-30" style="margin: auto;">
            <div class="h-100 bg-light p-30 d-flex">
                <img src="/images/sellers/{{$seller->photo}}" alt="" style="width: 200px; height: 200px; object-fit: cover; margin-right: 20px;">
                <div>
                    <h3>{{$seller->name}}</h3>
                    <div class="d-flex mb-3">
                        <small class="pt-1">{{$seller->rating}}</small>
                        <div class="text-primary mr-2">
                            <small class="fas fa-star ml-1"></small>
                        </div>
                    </div>
                    <p>{{$seller->description}}</p>
                    <a href="/seller/create" class='btn'>Создать товар</a> <a href="/seller/getProducts" class='btn'>Мои товары и заявки</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row px-xl-5" style="margin: auto;">
        <div class="col">
            <div class="bg-light p-30 d-flex flex-column h-100">
                <div class="nav nav-tabs mb-4">
                    <a class="nav-item nav-link text-dark active" data-toggle="tab" href="#tab-pane-1">Информация</a>
                </div>
                <div class="tab-content flex-grow-1">
                    <div class="tab-pane fade show active" id="tab-pane-1">
                        <h4 class="mb-3">Информация о продавце</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item px-0"><b>Организация:</b> {{$seller->type}} - {{$seller->organization}}</li>
                                    <li class="list-group-item px-0"><b>Тип Организации:</b> {{$seller->reduction}} ({{$seller->type}})</li>
                                    <li class="list-group-item px-0"><b>Регистрационный номер:</b> {{$seller->registration_number}}</li>
                                    @if ($seller->organization_type_id!=2)
                                        <li class="list-group-item px-0"><b>КПП:</b> {{$seller->kpp}}</li>
                                    @endif
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item px-0"><b>ОГРН @if ($seller->organization_type_id==2) {{$seller->reduction}} @endif:</b> {{$seller->ogrn}}</li>
                                    <li class="list-group-item px-0"><b>ИНН:</b> {{$seller->inn}}</li>
                                    <li class="list-group-item px-0"><b>Страна:</b> {{$seller->country}}</li>
                                    @if ($seller->organization_type_id!=2)
                                        <li class="list-group-item px-0"><b>Юридический адрес:</b> {{$seller->legal_address}}</li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media (max-width: 768px) { /* Измените 768px на нужное значение для вашего дизайна */
    .h-100 {
        flex-direction: column; /* Изменяем направление flex на колонку */
        align-items: center; /* Центрируем содержимое */
    }

    .h-100 img {
        margin-right: 0; /* Убираем отступ справа */
        margin-bottom: 20px; /* Добавляем отступ снизу для разделения с текстом */
    }
}

</style>








@include ('/layouts/footer')