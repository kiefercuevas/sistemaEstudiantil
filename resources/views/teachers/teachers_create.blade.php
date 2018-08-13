@extends('layouts.landingPage');

@section('title', 'Crear Profesor')
@section('title-content', 'Crear Profesor')
@section('content')
@if(Session::has('message'))
<div class="alert alert-danger" id='Danger'>
    {{ session::get('message') }}
</div>
@endif
	<div id="content" class="jumbotron main">
		<h1 class="text-center padding ">Profesor</h1>
		<div class="container">
			<div class="row">
				<div class="panel panel-danger">
					<div class="panel-heading">
						<h2 class="panel-title">Crear Profesor</h2>
					</div>
					<div class="panel-body">
						@include('alerts.requets')

						{{ Form::open(['route' => 'teachers.store', 'method' => 'POST']) }}
			                <fieldset class="col-sm-10 col-sm-offset-1">
			                    <!-- Form Name -->
			                    <!-- Prepended text-->
	
			                    {!!Form::token()!!}

								<h4>Información del profesor</h4>

                                <div class="form-group col-sm-6 ">
			                        <label class="control-label" for="names">Nombres</label>
			                        <input type="text" class="form-control" id="names" name="names" placeholder="Nombres profesor" value="{{ old('names')}}">
			                    </div>
			                    <div class="form-group col-sm-6 ">
			                        <label class="control-label" for="last_names">Apellidos</label>
			                        <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Apellidos profesor" value="{{ old('last_name') }}">
			                    </div>
								 <div class="form-group col-sm-6">
			                    <label class="control-label" for="subjects">Asignaturas</label>
								<div class="dropdown " name="subjects">
  								<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Materias
  								<span class="caret"></span></button>
  								<ul class="dropdown-menu">
								@foreach($subjects as $subject)	
    							<li><input type="checkbox" name="subject_selected[]" value="{{$subject->id}}" 
									id="subject_selected" >{{$subject->subject}}</li>
								@endforeach
  								</ul>
								</div>
			                    </div>
			                  <div class="form-group col-sm-6">
							  <label class="control-label" for="gender">Genero</label>
			                    <select id="gender" name="gender" class="form-control">
			                        	<option disabled selected value> -- Genero -- </option>
			                        	<option value='Hombre' @if(old('gender') == 'Hombre') {{ 'selected' }} @endif>Hombre</option>
			                        	<option value='Mujer' @if(old('gender') == 'Mujer') {{ 'selected' }} @endif>Mujer</option>
			                        </select>
								</div>
			                   
								    <div class="form-group col-sm-12">
    <label for="identity_card" class="control-label">Cedula o Pasaporte</label>
    <div class="input-group">
      <input type="text" class="form-control" id="identity_card" name="identity_card" placeholder="Ingrese su identificación" value="{{ old('identity_card') }}">
      <div class="input-group-btn">
        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"> Opción<span class="caret"></span></button>
        <ul class="dropdown-menu pull-right">
           <li id="cedula"><a href="#">Cedula</a></li>
          <li id="pasaporte"><a href="#">Pasaporte</a></li>
        </ul>
      </div><!-- /btn-group -->
    </div><!-- /input-group -->
    </div>

			                    <div class="form-group col-sm-6">
			                        <label class="control-label" for="personal_phone">Telefono</label>
			                        <input type="text" class="form-control" id="personal_phone" name="personal_phone" placeholder="telefono profesor" value="{{ old('personal_phone') }}">
			                    </div>
			                    <div class="form-group col-sm-6">
			                        <label class="control-label" for="cellphone">Celular</label>
			                        <input type="text" class="form-control" id="cellphone" name="cellphone" placeholder="movil profesor" value="{{ old('cellphone') }}">
			                    </div>
								 <div class="form-group col-sm-6">
			                        <label class="control-label" for="civil_status">Estado Civil</label>
			                        <select id="civil_status" name="civil_status" class="form-control">
			                        	<option disabled selected value> -- Estado civil -- </option>
			                        	<option @if(old('civil_status') == 'Soltero/a') {{ 'selected' }} @endif>Soltero/a</option>
			                        	<option @if(old('civil_status') == 'Casado/a') {{ 'selected' }} @endif>Casado/a</option>
			                        	<option @if(old('civil_status') == 'Comprometido/a') {{ 'selected' }} @endif>Comprometido/a</option>
			                        	<option @if(old('civil_status') == 'Divorciado/a') {{ 'selected' }} @endif>Divorciado/a</option>
			                        	<option @if(old('civil_status') == 'Viudo/a') {{ 'selected' }} @endif>Viudo/a</option>
			                        </select>
			                    </div>
								<div class="form-group col-sm-6">
			                        <label class="control-label" for="address">Direccion</label>
			                        <input type="text" class="form-control" id="address" name="address" placeholder="Direccion del profesor" value="{{ old('address') }}"> 
			                    </div>

                                <!--Usuario-->
                                <div class="form-group col-sm-6 ">
			                        <label class="control-label" for="email">Email</label>
			                        <input type="text" class="form-control" id="email" name="email" placeholder="email profesor" value="{{ old('email') }}">
			                    </div>
                                 <div class="form-group col-sm-6">
        					<label class="control-label" for="password">
           					 Password
        					</label>
        						{{ Form::password('password',['class'=>'form-control','placeholder'=>"Ingrese su contraseña"]) }}
    						</div>
								<div class="form-group col-sm-6">
        					{!!Form::label('status','Estatus Profesor',['class'=>'control-label'])!!}<br>
        					<input type="radio" name="status" value=1 checked>Activo
        					<br>
        					<input type="radio" name="status" value=0>Inactivo
    						</div>
			                    <!-- Button -->
			                    {!! Form::submit('Crear Profesor',['class' => 'btn btn-primary btn-block']) !!}
			                </fieldset>
						{!! Form::close() !!}
						<hr>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

	@include('forms.alerts')

