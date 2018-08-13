@extends('layouts.landingPage')
@section('title', 'Usuarios')
@section('title-content', 'Usuarios')
@section('content')
<div id="content" class="jumbotron main">
		<h1 class="text-center padding ">Usuario</h1>
		<div class="container">
			<div class="row">
				<div class="panel panel-danger">
					<div class="panel-heading">
						<h2 class="panel-title">Editar Usuario</h2>
					</div>
					<div class="panel-body">
					@include('alerts.requets')
						{!! Form::model($users,['route' =>  ['users.update',$users->id], 'method' => 'PUT']) !!}
			                <fieldset class="col-sm-10 col-sm-offset-1">
			                    <!-- Form Name -->
			                    <!-- Prepended text-->
			                    {!!Form::token()!!}


			                    <h4>Información del Usuario</h4>

								<div class="form-group col-sm-6">
			                        <label class="control-label" for="nombres">Nombres</label>
			                        <input type="text" class="form-control" id="names" name="names" value="{{ $users->names }}">
			                    </div>
			                    <div class="form-group col-sm-6">
			                        <label class="control-label" for="nombres">Apellidos</label>
			                        <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $users->last_name }}">
			                    </div>
			                     <div class="form-group col-sm-12">
			                        <label class="control-label" for="nombres">Correo</label>
			                        <input type="text" class="form-control" id="email" name="email" value="{{ $users->email }}">
			                    </div>

			                    <div class="form-group col-sm-6">
			                        <label class="control-label" for="nombres">Contraseña</label>
			                        <input type="password" class="form-control" id="password" name="password">
			                    </div>
			                    <div class="form-group col-sm-6">
			                        <label class="control-label" for="nombres">Confirmar contraseña</label>
			                        <input type="password" class="form-control"  name="password_confirmation">
			                    </div>

			                    {!! Form::submit('Editar Usuario',['class' => 'btn btn-primary btn-block']) !!}
			                </fieldset>
						{!! Form::close() !!}
						<hr>
					</div>

				</div>
			</div>
		</div>
	</div>
@endsection
@section('script')
@include('forms.alerts')
@endsection