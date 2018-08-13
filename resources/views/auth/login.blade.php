@extends('auth.template_log')
@section('title', 'Log in')

@section('content')
    <div class="main-login">
        <div class="container">
            <div class="row">
                <div class="col-sm-6  col-sm-offset-3 form-box">
                    <figure><img src="img/itsc_logo.jpg" alt=""></figure>
                    <h1>Instituto Técnico Superior Comunitario</h1>
                    <div class="row form-top">
                        <div class="col-sm-8 form-top-left">
                            <h3>Acceder al sistema de nivelación</h3>
                            <p>Ingrese su nombre de usuario y contraseña</p>
                        </div>
                        <div class="col-sm-4 form-top-right"><i class="fa fa-lock"></i></div>
                    </div>
                     
                    <div class="row form-bottom">
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                                {{ csrf_field() }}
                                <label for="email" class="sr-only"></label>
                                <input type="email" class="form-control" name="email" id="form-email" value="{{old('email')}}" placeholder="Correo Electronico" required autofocus>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="sr-only"></label>
                                <input type="password" class="form-control" name="password" id="form-password" placeholder="Contraseña">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                                <br><input type="submit" id="form-submit" class="btn btn-lg btn-block" value="Acceder">

                            </div>
                           
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
