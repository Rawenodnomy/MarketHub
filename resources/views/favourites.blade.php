@include ('/layouts/header')
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <span class="breadcrumb-item active">Избранное</span>
                </nav>
            </div>
        </div>
    </div>

    
    <div class="container-fluid" style='margin-bottom: 200px;'>
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5" id='main_block' style="margin: auto;">
            @if ($favourites!=[])
                <table class="table table-light table-borderless table-hover text-center mb-0">
                    <thead class="thead-dark">
                        <tr><th></th><th></th><th></th><th></th><th></th><th></th></tr>
                    </thead>
                    <tbody class="align-middle">
                        @foreach ($favourites as $item)
                            <tr id='block_{{$item->product_id}}'>
                                
                                <td><a href="/getProduct/{{$item->product_id}}"><img src="/images/products/{{$item->photo}}" alt="{{$item->photo}}" style="width: 75px; height: 76px; object-fit:cover;"></a></td>
                                <td class="align-middle">{{$item->name}}</td>
                                <td class="align-middle">{{$item->price}} ₽</td>
                                <td class="align-middle">{{$item->color}}</td>
                                <td class="align-middle">{{$item->article}}</td>
                                <td class="align-middle fav_btns" id='{{$item->product_id}}'><i class="fa fa-heart" style="font-size: 150%; cursor: pointer;"></i></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else 
                <p style='text-align: center;'>Избранных товаров нет</p>
            @endif
            </div>

        </div>
    </div>

<script src="/assets/js/favPage.js" defer type="module"></script>
@include ('/layouts/footer')