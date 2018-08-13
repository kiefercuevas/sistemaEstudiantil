@extends('layouts.landingPage');

@section('title', 'Editar Profesor')
@section('title-content', 'Editar Profesor')
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
						<h2 class="panel-title">editar Profesor</h2>
					</div>
					<div class="panel-body">
						{!! Form::model($users,['route' =>  ['teachers.update',$users->id], 'method' => 'PUT']) !!}
			                <fieldset class="col-sm-10 col-sm-offset-1">
			                    <!-- Form Name -->
			                    <!-- Prepended text-->
			                    {!!Form::token()!!}


			                    <h4>Información del profesor</h4>

                                <div class="form-group col-sm-6 ">
			                        <label class="control-label" for="names">Nombres</label>
			                        <input type="text" class="form-control" id="names" name="names" placeholder="Nombres profesor" value='{{$users->names}}'>
			                    </div>
			                    <div class="form-group col-sm-6 ">
			                        <label class="control-label" for="last_names">Apellidos</label>
			                        <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Apellidos profesor" value='{{$users->last_name}}'>
			                    </div>
								<div class="form-group col-sm-6">
							  <label class="control-label" for="gender">Genero</label>
			                    <select id="gender" name="gender" class="form-control">

									@if ($users->gender == 'Hombre')
			                        	<option  selected value ='Hombre'>Hombre</option>
			                        	<option value='mujer'>Mujer</option>
									@endif

									@if ($users->gender == 'Mujer')
										<option  selected value ='Mujer'>Mujer</option>
			                        	<option value='Hombre'>Hombre</option>
									@endif

			                    </select>
								</div>

			                    
			                    <div class="form-group col-sm-12">
    <label for="identity_card" class="control-label">Cedula o Pasaporte</label>
    <div class="input-group">
      <input type="text" class="form-control" id="identity_card" name="identity_card" placeholder="Ingrese su identificación" value="{{$users->identity_card}}">
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
			                        <input type="text" class="form-control" id="personal_phone" name="personal_phone" placeholder="telefono profesor" value='{{$users->personal_phone}}'>
			                    </div>
			                    <div class="form-group col-sm-6">
			                        <label class="control-label" for="cellphone">Celular</label>
			                        <input type="text" class="form-control" id="cellphone" name="cellphone" placeholder="movil profesor" value='{{$users->cellphone}}'>
			                    </div>
								 <div class="form-group col-sm-6">
			                        <label class="control-label" for="civil_status">Estado Civil</label>
			                        <select id="civil_status" name="civil_status" class="form-control">
			                        	<option  selected value='{{$users->civil_status}}'>{{$users->civil_status}}</option>
			                        	<option>Soltero/a</option>
			                        	<option>Casado/a</option>
			                        	<option>Comprometido/a</option>
			                        	<option>Divorciado/a</option>
			                        	<option>Viudo/a</option>
			                        </select>
			                    </div>
								<div class="form-group col-sm-6">
			                        <label class="control-label" for="address">Direccion</label>
			                        <input type="text" class="form-control" id="address" name="address" placeholder="Direccion del profesor" value='{{$users->address}}'>
			                    </div>

                                <!--Usuario-->
                                <div class="form-group col-sm-6 ">
			                        <label class="control-label" for="email">Email</label>
			                        <input type="text" class="form-control" id="email" name="email" placeholder="email profesor" value='{{$users->email}}'>
			                    </div>
                            <div class="form-group col-sm-6">
        					{!!Form::label('status','Estatus Profesor',['class'=>'control-label'])!!}<br>
        					<input type="radio" name="status" value=1 @if($users->status == 1) {{'checked'}} @endif>Activo
        					<br>
        					<input type="radio" name="status" value=0 @if($users->status == 0) {{'checked'}} @endif>Inactivo
    						</div>
			                    {!! Form::submit('Editar Profesor',['class' => 'btn btn-primary btn-block']) !!}
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
