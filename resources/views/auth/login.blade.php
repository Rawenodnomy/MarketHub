@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('login') }}">
        @csrf
    <!-- Checkout Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">

            
            <div class="col-lg-8" style="margin: auto;">
                
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Авторизация</span></h5>
                
                <div class="bg-light p-30 mb-5">
                    <div class="">
                        <div class="col-md-6 form-group" style="margin: auto;">
                            <label for="email">Почта <span style="color: red;">*</span></label>
                            <input class="form-control @error('email') is-invalid @enderror" id="email" type="email" name="email" value="{{ old('email') }}" autofocus>
                            @error('email')
                                <p style="color: red;">{{ $message }}</p>
                            @enderror
                        </div>
                        <br>
                        <div class="col-md-6 form-group" style="margin: auto;">
                            <label for="password">Пароль <span style="color: red;">*</span></label>
                            <input class="form-control @error('password') is-invalid @enderror" id="password" type="password"  name="password">
                            @error('password')
                                <p style="color: red;">{{ $message }}</p>
                            @enderror
                        </div>
                        <br>
                        <p style="text-align: center;">
                            <button class="btn col-md-6 btn-primary font-weight-bold my-3 py-3">Войти</button>
                        </p>
                    </div>
                </div>

            </div>
   
        </div>
    </div>
    <!-- Checkout End -->
</form>
@endsection
