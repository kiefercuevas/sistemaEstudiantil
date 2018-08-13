@extends('layouts.landingPage');

@section('title', 'Crear Sección')
@section('title-content', 'Crear Sección')
@section('content')
@if(Session::has('message'))
<div class="alert alert-danger" id='Danger'>
    {{ session::get('message') }}
</div>
@endif
	<div id="content" class="jumbotron main">
		<h1 class="text-center padding ">Sección</h1>
		<div class="container">
			<div class="row">
				<div class="panel panel-danger">
					<div class="panel-heading">
						<h2 class="panel-title">Crear Sección</h2>
					</div>
					<div class="panel-body">
						@include('alerts.requets')
						{!! Form::open(['route' => 'sections.store', 'method' => 'POST']) !!}
			                <fieldset class="col-sm-10 col-sm-offset-1">
			                    <!-- Form Name -->
			                    <!-- Prepended text-->
			                    {!!Form::token()!!}
			                    <h4>Información de sección</h4>
							<div class="form-group col-sm-6">
			                        <label class="control-label" for="section">Nombre de Sección</label>
			                        <input list="sections"  class="form-control" id="section" name="section" placeholder="Numero de Sección" value="{{ old('section')}}">
			                    </div>
								<div class="form-group col-sm-6">
			                        <label class="control-label" for="subjects_id">Asignatura</label>
			                        <select id="subjects_id" name="subjects_id" class="form-control">
			                        	<option disabled selected value> -- select an option -- </option>
			                        	@foreach($subject as $subjects)
			                        	<option value="{{$subjects->id}}" @if(old('subjects_id') == $subjects->id) {{ 'selected' }} @endif>{{$subjects->subject}} </option>
			                        	@endforeach
			                        </select>
			                    </div>
			                    <div class="form-group col-sm-6">
			                        <label class="control-label" for="users_id">Docentes</label>
			                        <select id="users_id" name="users_id" class="form-control">
			                        	<option disabled selected value> -- select an option -- </option>
			                        	@foreach($teacher as $teachers)
				                        	<option value="{{$teachers->id}}" @if(old('users_id') == $teachers->id) {{ 'selected' }} @endif>{{$teachers->names}} {{$teachers->last_name}}</option>
			                        	@endforeach
			                        </select>
			                    </div>
								<div class="form-group col-sm-6">
			                        <label class="control-label" for="classrooms_id">Aula</label>
			                        <select id="classrooms_id" name="classrooms_id" class="form-control">
			                        	<option disabled selected value> -- select an option -- </option>
			                        	@foreach($classroom as $classrooms)
									
										<option value="{{$classrooms->id}}" @if(old('classrooms_id') == $classrooms->id) {{ 'selected' }} @endif>{{$classrooms->location}} </option>
			                        	
										@endforeach
			                        </select>
			                    </div>
								<div class="form-group col-sm-6">
			                        <label class="control-label" for="academic_periods_id">Periodo Academico</label>
			                        <select id="academic_periods_id" name="academic_periods_id" class="form-control">
			                        	<option disabled selected value> -- select an option -- </option>
			                        	@foreach($academic_period as $academic_periods)
			                        	
										<option value="{{$academic_periods->id}}" @if(old('academic_periods_id') == $academic_periods->id) {{ 'selected' }} @endif>{{$academic_periods->academic_period}} </option>
			                        	
										@endforeach
			                        </select>
			                    </div>
			                    <div class="form-group col-sm-6">
			                        <label class="control-label" for="shift">Tanda</label>
			                        <select id="shift" name="shift" class="form-control">
			                        	<option disabled selected value>-- select an option --</option>
			                        	<option @if(old('shift') == 'Matutina') {{ 'selected' }} @endif>Matutina</option>
			                        	<option @if(old('shift') == 'Nocturna') {{ 'selected' }} @endif>Nocturna</option>
			                        </select>
			                    </div>
			                    
			                    <div class="form-group col-sm-6">
			                        <label class="control-label" for="day_one">Primer dia</label>
			                        <select id="day_one" name="day_one" class="form-control">
			                        	<option disabled selected value>-- select an option --</option>
			                        	<option @if(old('day_one') == 'Lunes') {{ 'selected' }} @endif>Lunes</option>
			                        	<option @if(old('day_one') == 'Martes') {{ 'selected' }} @endif>Martes </option>
			                        	<option @if(old('day_one') == 'Miercoles') {{ 'selected' }} @endif>Miercoles </option>
			                        	<option @if(old('day_one') == 'Jueves') {{ 'selected' }} @endif>Jueves </option>
			                        	<option @if(old('day_one') == 'Viernes') {{ 'selected' }} @endif>Viernes </option>
			                        	<option @if(old('day_one') == 'Sabado') {{ 'selected' }} @endif>Sabado </option>
			                        </select>
			                    </div>
			                    <div class="form-group col-sm-6">
			                        <label class="control-label" for="day_two">Segundo dia</label>
			                        <select id="day_two" name="day_two" class="form-control">
			                        	<option disabled selected value>-- select an option --</option>
			                        	<option @if(old('day_two') == 'Lunes') {{ 'selected' }} @endif>Lunes</option>
			                        	<option @if(old('day_two') == 'Martes') {{ 'selected' }} @endif>Martes </option>
			                        	<option @if(old('day_two') == 'Miercoles') {{ 'selected' }} @endif>Miercoles </option>
			                        	<option @if(old('day_two') == 'Jueves') {{ 'selected' }} @endif>Jueves </option>
			                        	<option @if(old('day_two') == 'Viernes') {{ 'selected' }} @endif>Viernes </option>
			                        	<option @if(old('day_two') == 'Sabado') {{ 'selected' }} @endif>Sabado </option>
			                        </select>
			                    </div>
			                    
			                    <div class="form-group col-sm-3">
			                        <label class="control-label" for="time_first">Hora inicio de clase</label>
			                        <input type="time" class="form-control" id="time_first" name="time_first" pattern="" value="{{ old('time_first')}}">
			                    </div>
			                    <div class="form-group col-sm-3">
			                        <label class="control-label" for="time_last">Hora final de clase</label>
			                        <input type="time" class="form-control" id="time_last" name="time_last" value="{{ old('time_last')}}">
			                    </div>


								<div class="form-group col-sm-3" >
			                        <label class="control-label" for="second_time_first">Hora inicio de clase2</label>
			                        <input type="time" class="form-control" id="second_time_first" name="second_time_first" value="{{ old('second_time_first')}}" pattern="">
			                    </div>
			                    <div class="form-group col-sm-3">
			                        <label class="control-label" for="second_time_last">Hora final de clase2</label>
			                        <input  type="time" class="form-control" id="second_time_last" name="second_time_last" value="{{ old('second_time_last')}}">
			                    </div>
								<div class="form-group col-sm-6">
			                        <label class="control-label" for="quota">Cupo</label>
			                        <input type="text" class="form-control" id="quota" name="quota" value="{{ old('quota')}}">
			                    </div> 
			                    <div class="form-group col-sm-6">
			                    	<label class="control-label" for="status">Estatus de sección</label><br>
			                    	<input type="radio" name="status"  id="status" value="1" checked> Activada<br>
  									<input type="radio" name="status"  id="status" value="0"> Desactivada
			                    </div>
								
			<datalist id="sections">
				@foreach($section as $sections)
  				<option value='{{$sections->section}}'>Seccion Usada:{{$sections->section}}-{{$sections->academic_period}}</option>
				@endforeach
			</datalist>
		
			                    <!-- Button -->
			                    {!! Form::submit('Crear Sección',['class' => 'btn btn-primary btn-block']) !!}
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
<script>
		
		 
        /*setTimeout(function() {
            $('#Danger').fadeToggle();
            }, 5000); // <-- time in milliseconds*/
	</script>
@endsection