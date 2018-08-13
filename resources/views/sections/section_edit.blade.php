@extends('layouts.landingPage');

@section('title', 'Crear Sección')
@section('title-content', 'Editar Sección')
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
						<h2 class="panel-title">Editar Sección</h2>
					</div>
					<div class="panel-body">
						@include('alerts.requets')
						{!! Form::open(['route' => ['sections.update', $section->id], 'method' => 'PUT']) !!}
             				<?php
            				$timelast       = $section->time_last;
            				$secondTimeLast = $section->second_time_last;
            				$timeToAdd = 1;

            				$timelastHourToSecond       = strtotime($timelast);
            				$secondTimelastHourToSecond = strtotime($secondTimeLast);

            				$minutesToAdd = $timeToAdd * 60;

            				$timeLastNewHour       = date('H:i', $timelastHourToSecond + $minutesToAdd);
            				$secondTimelastNewHour = date('H:i', $secondTimelastHourToSecond + $minutesToAdd);
        					?>
						    <fieldset class="col-sm-10 col-sm-offset-1">
			                    <!-- Form Name -->
			                    <!-- Prepended text-->
			                    {!!Form::token()!!}
			                    <h4>Información de sección</h4>
								<div class="form-group col-sm-6">
			                        <label class="control-label" for="section">Numero de Sección</label>
			                        <input list="sections" class="form-control" id="section" name="section" placeholder="Numero de Sección" value="{{$section->section}}">
			                    </div>
			                    <div class="form-group col-sm-6">
			                        <label class="control-label" for="subjects_id">Asignatura</label>
			                        <select id="subjects_id" name="subjects_id" class="form-control">
			                        	@foreach($subjects as $subject)
			                        		<option value="{{$subject->id}}" @if($subject->id == $section->subjects_id) {{ 'selected' }} @endif>{{$subject->subject}}</option>
			                        	@endforeach
			                        </select>
			                    </div>
			                    <div class="form-group col-sm-6">
			                        <label class="control-label" for="users_id">Docentes</label>
			                        <select id="users_id" name="users_id" class="form-control">
			                        	@foreach($teachers as $teacher)
				                        	<option value="{{$teacher->id}}" @if($teacher->id == $section->users_id) {{ 'selected' }} @endif >{{$teacher->names}} {{$teacher->last_name}}</option>
			                        	@endforeach
			                        </select>
			                    </div>
								<div class="form-group col-sm-6">
			                        <label class="control-label" for="classrooms_id">Aula</label>
			                        <select id="classrooms_id" name="classrooms_id" class="form-control">
			                        	@foreach($classrooms as $classroom)
			                        	<option value="{{$classroom->id}}" @if($classroom->id == $section->classrooms_id) {{ 'selected' }} @endif >{{$classroom->location}} </option>
			                        	@endforeach
			                        </select>
			                    </div>
								<div class="form-group col-sm-6">
			                        <label class="control-label" for="academic_periods_id">Periodo Academico</label>
			                        <select id="academic_periods_id" name="academic_periods_id" class="form-control">
			                        	@foreach($academic_periods as $academic_period)
			                        	<option value="{{$academic_period->id}}" @if($academic_period->id == $section->academic_periods_id) {{ 'selected' }} @endif >{{$academic_period->academic_period}} </option>
			                        	@endforeach
			                        </select>
			                    </div>
			                    <div class="form-group col-sm-6">
			                        <label class="control-label" for="shift">Tanda</label>
			                        <select id="shift" name="shift" class="form-control">
										<option @if($section->shift == "Matutina") {{ 'selected' }} @endif>Matutina</option>
		                        		<option @if($section->shift == "Nocturna") {{ 'selected' }} @endif>Nocturna</option>	
			                        </select>
			                    </div>
			                    
			                    <div class="form-group col-sm-6">
			                        <label class="control-label" for="day_one">Primer dia</label>
			                        <select id="day_one" name="day_one" class="form-control">
			                        	<option disabled selected value>-- select an option --</option>
			                        	<option @if($section->day_one == 'Lunes') {{ 'selected' }} @endif>Lunes</option>
			                        	<option @if($section->day_one == 'Martes') {{ 'selected' }} @endif>Martes </option>
			                        	<option @if($section->day_one == 'Miercoles') {{ 'selected' }} @endif>Miercoles </option>
			                        	<option @if($section->day_one == 'Jueves') {{ 'selected' }} @endif>Jueves </option>
			                        	<option @if($section->day_one == 'Viernes') {{ 'selected' }} @endif>Viernes </option>
			                        	<option @if($section->day_one == 'Sabado') {{ 'selected' }} @endif>Sabado </option>
			                        </select>
			                    </div>
			                    <div class="form-group col-sm-6">
			                        <label class="control-label" for="day_two">Segundo dia</label>
			                        <select id="day_two" name="day_two" class="form-control">
			                        	<option disabled selected value>-- select an option --</option>
			                        	<option @if($section->day_two == 'Lunes') {{ 'selected' }} @endif>Lunes</option>
			                        	<option @if($section->day_two == 'Martes') {{ 'selected' }} @endif>Martes </option>
			                        	<option @if($section->day_two == 'Miercoles') {{ 'selected' }} @endif>Miercoles </option>
			                        	<option @if($section->day_two == 'Jueves') {{ 'selected' }} @endif>Jueves </option>
			                        	<option @if($section->day_two == 'Viernes') {{ 'selected' }} @endif>Viernes </option>
			                        	<option @if($section->day_two == 'Sabado') {{ 'selected' }} @endif>Sabado </option>
			                        </select>
			                    </div>
			                    
			                    <div class="form-group col-sm-3">
			                        <label class="control-label" for="time_first">Hora inicio de clase</label>
			                        <input type="time" class="form-control" id="time_first" name="time_first" value="{{$section->time_first}}" pattern="">
			                    </div>
			                    <div class="form-group col-sm-3">
			                        <label class="control-label" for="time_last">Hora final de clase</label>
			                        <input type="time" class="form-control" id="time_last" name="time_last" value="{{$timeLastNewHour}}">
			                    </div>

			                    <div class="form-group col-sm-3">
			                        <label class="control-label" for="second_time_first">Hora inicio de clase2</label>
			                        <input type="time" class="form-control" id="second_time_first" name="second_time_first" pattern="" value="{{$section->second_time_first}}">
			                    </div>
			                    <div class="form-group col-sm-3">
			                        <label class="control-label" for="second_time_last">2da Hora final de clase2</label>
									@empty($section->second_time_last)
									<input type="time" class="form-control" id="second_time_last" name="second_time_last" value="{{$section->second_time_last}}">
									@endempty
									@isset($section->second_time_last)
									<input type="time" class="form-control" id="second_time_last" name="second_time_last" value="{{$secondTimelastNewHour}}">
									@endisset
			                    </div>
			                    
			                    <div class="form-group col-sm-3">
			                        <label class="control-label" for="quota">Cupo</label>
			                        <input type="text" class="form-control" id="quota" name="quota" value="{{$section->quota}}">
			                    </div>
			                    <div class="form-group col-sm-3">
			                    	<label class="control-label" for="status">Estatus de sección</label><br>
			                    	<input type="radio" name="status"  id="status" value="1" @if($section->status == 1) checked @endif> Activada<br>
  									<input type="radio" name="status"  id="status" value="0" @if($section->status == 0) checked @endif> Desactivada
			                    </div>
			                    <!-- Button -->
			                    {!! Form::submit('Editar Sección',['class' => 'btn btn-primary btn-block']) !!}
			                </fieldset>
						{!! Form::close() !!}
						<hr>
					</div>
				</div>
			</div>
		</div>
	</div>
<datalist id="sections">
@foreach($sectionUseds as $sectionUsed)
  <option value='{{$sectionUsed->section}}'>Seccion Usada:{{$sectionUsed->section}}-{{$sectionUsed->academic_period}}</option>
@endforeach
@endsection
@section('script')
	<script>
		$(document).ready(function(){
        	$('#time_first').datetimepicker({
		        format: 'hh:mm A'
		    });
      	});
	</script>
@endsection