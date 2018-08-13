@extends('layouts.landingPage');

@section('title', 'Crear Estudiante')
@section('title-content', 'Editar Estudiantes')
@section('content')
	<div id="content" class="jumbotron main">
		<h1 class="text-center padding ">Estudiante</h1>
		<div class="container">
			<div class="row">
				<div class="panel panel-danger">
					<div class="panel-heading">
						<h2 class="panel-title">Editar Estudiante</h2>
					</div>
					<div class="panel-body">
						@include('alerts.requets')
						{!! Form::model($student, ['route' => ['students.update', $student->id], 'method' => 'PUT']) !!}
			                <fieldset class="col-sm-10 col-sm-offset-1">
			                    <!-- Form Name -->
			                    <!-- Prepended text-->
			                    {!!Form::token()!!}
			                    <h4>Información personal del estudiante</h4>
			                    <div class="form-group col-sm-6 ">
			                        <label class="control-label" for="nombres">Nombres</label>
			                        <input type="text" class="form-control" id="names" name="names" value="{{$student->names}}">
			                    </div>
			                    <div class="form-group col-sm-6 ">
			                        <label class="control-label" for="nombres">Apellidos</label>
			                        <input type="text" class="form-control" id="last_name" name="last_name" value="{{$student->last_name}}">
			                    </div>
			                    <div class="form-group col-sm-6">
			                    	{!! Form::label('civil_status', 'Estado Civil') !!}
			                        {!!Form::select('civil_status',[
			                        	'Soltero/a' => 'Soltero/a',
			                        	'Casado/a' => 'Casado/a',
			                        	'Comprometido/a' => 'Comprometido/a',
			                        	'Divorciado/a' => 'Divorciado/a',
			                        	'Viudo/a' => 'Viudo/a',
			                        ],null,['class' => 'form-control'])!!}
			                    </div>
			                    <div class="form-group col-sm-6">
			                        <label class="control-label" for="nombres">Fecha Nacimiento</label>
			                        <input type="date" value="{{$student->birthday}}" class="form-control" id="birthday" name="birthday" placeholder="Fecha Nacimiento" >
			                    </div>
			                    <div class="form-group col-sm-6">
    <label for="identity_card" class="control-label">Cedula o Pasaporte</label>
    <div class="input-group">
      <input type="text" class="form-control" id="identity_card" name="identity_card" placeholder="Ingrese su identificación" value="{{$student->identity_card}}">
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
			                        <label class="control-label" for="nombres">Email</label>
			                        <input type="email" class="form-control" id="email" name="email" value="{{$student->email}}">
			                    </div>
			                    <h4>Información Universitaria del estudiante</h4><br>
			                    <div class="form-group col-sm-6">
			                        <label class="control-label" for="condition">Condición</label>
			                        <select id="condition" name="condition" class="form-control">
			                        	<option value="ESP-100" @if($student->condition == "ESP-100") {{ 'selected' }} @endif>ESP-100 Lengua Española</option>
			                        	<option value="MAT-100" @if($student->condition == "MAT-100") {{ 'selected' }} @endif>MAT-100 Matematica</option>
			                        	<option value="ESP-100/MAT-100" @if($student->condition == "ESP-100/MAT-100") {{ 'selected' }} @endif>ESP-100 Lengua Española / MAT-100 Matematica</option>
			                        </select>
			                    </div>
			                    <div class="form-group col-sm-6">
			                    	{!! Form::label('shift', 'Tanda') !!}
			                        {!!Form::select('shift',[
			                        	'Matutina' => 'Matutina',
			                        	'Nocturna' => 'Nocturna',
			                        ],null,['class' => 'form-control'])!!}
			                    </div>
			                    <div class="form-group col-sm-5">
			                        <label class="control-label" for="nombres">Veces Inscritos al programa</label>
			                        <input type="text" class="form-control" id="inscribed_opportunity" name="inscribed_opportunity" value="{{$student->inscribed_opportunity}}">
			                    </div>
			                    <div class="form-group col-sm-7">
			                        {!! Form::label('debt', 'Deuda') !!}
			                        	@if($student->debt)
				                        	{!! Form::checkbox('debt', 'value', true)!!}
				                        @else
				                        	{!! Form::checkbox('debt', 'value', false)!!}
				                        @endif
			                        </label>
			                    </div>
			                    <div class="form-group col-sm-12">
			                    	{!! Form::label('career', 'Carrera') !!}
			                        {!! Form::select('career',[
			                        	'Técnico Superior en Higiene Dental' => 'Técnico Superior en Higiene Dental',
			                        	'Técnico Superior en Enfermería' => 'Técnico Superior en Enfermería',
			                        	'Técnico Superior en Imágenes Médicas' => 'Técnico Superior en Imágenes Médicas',
			                        	'Técnico Superior en Mecánica Dental' => 'Técnico Superior en Mecánica Dental',

			                        	'Técnico Superior en Administración de Redes' => 'Técnico Superior en Administración de Redes',
			                        	'Técnico Superior en Desarrollo de Software' => 'Técnico Superior en Desarrollo de Software',
			                        	'Técnico Superior en Soporte Informático' => 'Técnico Superior en Soporte Informático',

			                        	'Técnico Superior en Fotografía' => 'Técnico Superior en Fotografía',
			                        	'Técnico Superior en Diseño de Modas' => 'Técnico Superior en Diseño de Modas',
			                        	'Técnico Superior en Diseño Gráfico' => 'Técnico Superior en Diseño Gráfico',
			                        	'Técnico Superior en Producción de Eventos' => 'Técnico Superior en Producción de Eventos',
			                        	'Técnico Superior en Diseño de Interiores' => 'Técnico Superior en Diseño de Interiores',
			                        	'Técnico Superior en Industria del Mueble' => 'Técnico Superior en Industria del Mueble',

			                        	'Técnico Superior en Gastronomía' => 'Técnico Superior en Gastronomía',
			                        	'Técnico Superior en Sistemas de Información Turística' => 'Técnico Superior en Sistemas de Información Turística',
			                        	'Técnico Superior en Gestión de Alojamiento Turístico' => 'Técnico Superior en Gestión de Alojamiento Turístico',
			                        	'Técnico Superior en Alimentos y Bebidas' => 'Técnico Superior en Alimentos y Bebidas',
			                        	'Técnico Superior en Empresas de Intermediación Turística' => 'Técnico Superior en Empresas de Intermediación Turística',
			                        	'Técnico Superior en Panadería y Repostería' => 'Técnico Superior en Panadería y Repostería',

			                        	'Técnico Superior en Tecnologías de Manufactura' => 'Técnico Superior en Tecnologías de Manufactura',
			                        	'Técnico Superior en Logística' => 'Técnico Superior en Logística',

			                        	'Técnico Superior en Construcción' => 'Técnico Superior en Construcción',
			                        	'Técnico Superior en Plomería' => 'Técnico Superior en Plomería',
			                        	'Técnico Superior Mecatronica' => 'Técnico Superior Mecatronica',
			                        	'Técnico Superior en Electrónica' => 'Técnico Superior en Electrónica',
			                        	'Técnico Superior en Electricidad' => 'Técnico Superior en Electricidad',
			                        	'Técnico Superior en Refrigeración' => 'Técnico Superior en Refrigeración',

			                        ],null,['class' => 'form-control'])!!}
			                        <br>
			                    </div>
			                    <!-- Button -->
			                    {!! Form::submit('Editar Estudiante',['class' => 'btn btn-primary btn-block']) !!}
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



