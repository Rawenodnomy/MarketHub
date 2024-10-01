<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Админ-панель | @yield('title')</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/admin/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="/admin/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/admin/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="/admin/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="/admin/plugins/summernote/summernote-bs4.min.css">
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="/admin/home" class="nav-link">Главная</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
      <a href="{{ route('logout') }} " class="nav-link"
           onclick="event.preventDefault();
                         document.getElementById('logout-form').submit();">
            {{ __('Выйти') }}
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/admin/home" class="brand-link">
      <span class="brand-text font-weight-light">Панель администратора</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="/admin/dist/img/AdminLTELogo.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{Auth::user()->name}}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

            @if(Auth::user()->is_admin==2)
            <li class="nav-item">
                <a href="#" class="nav-link">
                <i class="nav-icon fa fa-heart"></i>
                <p>
                    Товары
                    <i class="fas fa-angle-left right"></i>
                </p>
                </a>
                <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('products.index')}}" class="nav-link">
                    <p>Все товары</p>
                    </a>
                </li>
                </ul>
            </li>


            <li class="nav-item">
                <a href="#" class="nav-link">
                <i class="nav-icon fa fa-user"></i>
                <p>
                    Продавцы
                    <i class="fas fa-angle-left right"></i>
                </p>
                </a>
                <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('sellers.index')}}" class="nav-link">
                    <p>Все продавцы</p>
                    </a>
                </li>
                </ul>
            </li>


            <li class="nav-item">
                <a href="#" class="nav-link">
                <i class="nav-icon fa fa-comment"></i>
                <p>
                    Отзывы
                    <i class="fas fa-angle-left right"></i>
                </p>
                </a>
                <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('reviews.index')}}" class="nav-link">
                    <p>Все отзывы</p>
                    </a>
                </li>
                </ul>
            </li>


            <li class="nav-item">
                <a href="#" class="nav-link">
                <i class="nav-icon fa fa-book"></i>
                <p>
                    Категории
                    <i class="fas fa-angle-left right"></i>
                </p>
                </a>
                <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('categories.index')}}" class="nav-link">
                    <p>Все категории</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('categories.create')}}" class="nav-link">
                    <p>Добавить категорию</p>
                    </a>
                </li>
                </ul>
            </li>



            <li class="nav-item">
                <a href="#" class="nav-link">
                <i class="nav-icon fa fa-folder"></i>
                <p>
                    Подкатегории
                    <i class="fas fa-angle-left right"></i>
                </p>
                </a>
                <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('subcategories.index')}}" class="nav-link">
                    <p>Все подкатегории</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('subcategories.create')}}" class="nav-link">
                    <p>Добавить подкатегорию</p>
                    </a>
                </li>
                </ul>
            </li>



            <li class="nav-item">
                <a href="#" class="nav-link">
                <i class="nav-icon far fa-question-circle"></i>
                <p>
                    Вопросы-ответы
                    <i class="fas fa-angle-left right"></i>
                </p>
                </a>
                <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('questAndAns.index')}}" class="nav-link">
                    <p>Все вопросы-ответы</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('questAndAns.create')}}" class="nav-link">
                    <p>Добавить вопрос-ответ</p>
                    </a>
                </li>
                </ul>
            </li>




            <li class="nav-item">
                <a href="#" class="nav-link">
                <i class="nav-icon fa fa-university"></i>
                <p>
                    Города
                    <i class="fas fa-angle-left right"></i>
                </p>
                </a>
                <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('city.index')}}" class="nav-link">
                    <p>Все города</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('city.create')}}" class="nav-link">
                    <p>Добавить город</p>
                    </a>
                </li>
                </ul>
            </li>




            <li class="nav-item">
                <a href="#" class="nav-link">
                <i class="nav-icon fa fa-home"></i>
                <p>
                    Пункты выдачи
                    <i class="fas fa-angle-left right"></i>
                </p>
                </a>
                <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('point.index')}}" class="nav-link">
                    <p>Все пункты выдачи</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('point.create')}}" class="nav-link">
                    <p>Добавить пункт выдачи</p>
                    </a>
                </li>
                </ul>
            </li>




            <li class="nav-item">
                <a href="#" class="nav-link">
                <i class="nav-icon fa fa-paint-brush"></i>
                <p>
                    Цвета
                    <i class="fas fa-angle-left right"></i>
                </p>
                </a>
                <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('color.index')}}" class="nav-link">
                    <p>Все цвета</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('color.create')}}" class="nav-link">
                    <p>Добавить цвет</p>
                    </a>
                </li>
                </ul>
            </li>





            <li class="nav-item">
                <a href="#" class="nav-link">
                <i class="nav-icon fa fa-users"></i>
                <p>
                    Работники
                    <i class="fas fa-angle-left right"></i>
                </p>
                </a>
                <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('worker.index')}}" class="nav-link">
                    <p>Все работники</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('worker.create')}}" class="nav-link">
                    <p>Добавить работника</p>
                    </a>
                </li>
                </ul>
            </li>



            <li class="nav-item">
                    <a href="#" class="nav-link">
                    <i class="nav-icon fa fa-truck"></i>
                    <p>
                        Заказы в статусе:
                        <i class="fas fa-angle-left right"></i>
                    </p>
                    </a>
                    <ul class="nav nav-treeview">

                    <?php $statuses = DB::select('SELECT * FROM statuses LIMIT 2'); ?>

                    @foreach ($statuses as $status)
                        <li class="nav-item">
                            <a href="{{ route('order.index', ['id' => $status->id]) }}" class="nav-link">
                            <p>{{$status->stage}}</p>
                            </a>
                        </li>
                    @endforeach



                    </ul>
            </li>






            @else
                <li class="nav-item">
                    <a href="#" class="nav-link">
                    <i class="nav-icon fa fa-heart"></i>
                    <p>
                        Товары на пункте
                        <i class="fas fa-angle-left right"></i>
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('work_products.index') }}" class="nav-link">Продукты

                        <p>Все Товары</p>
                        </a>
                    </li>
                    </ul>
                </li>


                <li class="nav-item">
                    <a href="#" class="nav-link">
                    <i class="nav-icon fa fa-truck"></i>
                    <p>
                        Заказы в статусе:
                        <i class="fas fa-angle-left right"></i>
                    </p>
                    </a>
                    <ul class="nav nav-treeview">

                    <?php $statuses = DB::select('SELECT * FROM statuses WHERE id = 3 OR id = 4'); ?>

                    @foreach ($statuses as $status)
                        <li class="nav-item">
                            <a href="{{ route('work_orders.index', ['id' => $status->id]) }}" class="nav-link">
                            <p>{{$status->stage}}</p>
                            </a>
                        </li>
                    @endforeach
                    </ul>
                </li>


                <li class="nav-item">
                    <a href="#" class="nav-link">
                    <i class="nav-icon fa fa-truck"></i>
                    <p>
                        Принятие товаров
                        <i class="fas fa-angle-left right"></i>
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('work_getProduct.index') }}" class="nav-link">
                            <p>Все заявки</p>
                            </a>
                        </li>
                    </ul>
                </li>




                <li class="nav-item">
                    <a href="#" class="nav-link">
                    <i class="nav-icon fa fa-truck"></i>
                    <p>
                        Обновление товаров
                        <i class="fas fa-angle-left right"></i>
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('work_update.index') }}" class="nav-link">
                            <p>Все заявки</p>
                            </a>
                        </li>
                    </ul>
                </li>
                
                
            @endif


        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @yield('content')
  </div>
 


  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="/admin/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="/admin/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="/admin/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="/admin/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="/admin/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="/admin/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="/admin/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="/admin/plugins/moment/moment.min.js"></script>
<script src="/admin/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="/admin/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="/admin/dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/admin/dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="/admin/dist/js/pages/dashboard.js"></script>
</body>
</html>