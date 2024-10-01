@extends('layouts.admin_layout')

@section('title', 'Главная')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Ключевые элементы</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">

          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    @if (Auth::user()->is_admin==1)
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{$pointProductsCount}}</h3>

                <p>Товаров хранится на пункте</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{$orderCount}}</h3>

                <p>Заказов в пункт</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{$acceptProductsCount}}</h3>

                <p>Заявок принятие товаров</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{$updateProductCount}}</h3>

                <p>Заявок на обновления количество</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->

        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    @else
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{$productsCount}}</h3>
                <p>Товаров на проверку</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="{{route('products.index')}}" class="small-box-footer">Перейти <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>



          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{$sellersCount}}</h3>

                <p>Заявок от продавцов</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="{{route('sellers.index')}}" class="small-box-footer">Перейти<i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>



          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{$reviewsCount}}</h3>

                <p>Отзывов</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="{{route('reviews.index')}}" class="small-box-footer">Перейти <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>






          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{$categoriesCount}}</h3>

                <p>Категорий</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="{{route('categories.index')}}" class="small-box-footer">Перейти <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>





          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-purple">
              <div class="inner">
                <h3>{{$subcategoriesCount}}</h3>

                <p>Подкатегорий</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="{{route('subcategories.index')}}" class="small-box-footer">Перейти <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>






          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-gray">
              <div class="inner">
                <h3>{{$questionsAnswerCount}}</h3>

                <p>Вопросов-ответов</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="{{route('questAndAns.index')}}" class="small-box-footer">Перейти <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>






          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-orange">
              <div class="inner">
                <h3>{{$citiesCount}}</h3>

                <p>Городов</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="{{route('city.index')}}" class="small-box-footer">Перейти <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>






          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-cyan">
              <div class="inner">
                <h3>{{$pointsCount}}</h3>

                <p>Пунктов выдачи</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="{{route('point.index')}}" class="small-box-footer">Перейти <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>




          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-teal">
              <div class="inner">
                <h3>{{$colorsCount}}</h3>

                <p>Цветов</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="{{route('color.index')}}" class="small-box-footer">Перейти <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>






          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-pink">
              <div class="inner">
                <h3>{{$adminsCount}}</h3>

                <p>Работников пунктов выдачи</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="{{route('worker.index')}}" class="small-box-footer">Перейти <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>










          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->

        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    @endif
    <!-- /.content -->
@endsection