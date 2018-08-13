@extends('layouts.landingPage');

@section('title', 'Crear Fecha calificacion')
@section('title-content', 'Fecha calificacion')
@section('content')
@if(Session::has('message'))
<div class="alert alert-danger" id='Danger'>
    {{ session::get('message') }}
</div>
@endif
	<div id="content" class="jumbotron main">
		<h1 class="text-center padding ">Fechas</h1>
		<div class="container">
			<div class="row">
				<div class="panel panel-danger">
					<div class="panel-heading">
						<h2 class="panel-title">Fecha calificaciones</h2>
					</div>
					<div class="panel-body">
						@include('alerts.requets')

						{{ Form::open(['route' => 'dates.store', 'method' => 'POST']) }}
			                <fieldset class="col-sm-10 col-sm-offset-1">
			                    <!-- Form Name -->
			                    <!-- Prepended text-->
	
			                    {!!Form::token()!!}

								<h4>PrimerParcial</h4>

                                <div class="form-group col-sm-6">
                                <label class="control-label" for="first_midterm_date_from">
                                    Fecha de Inicio
                                </label>
                                <input class="form-control col-md-7 col-xs-12" name="first_midterm_date_from" type="date" value="{{ old('first_midterm_date_from') }}">
                                </input>
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="control-label" for="first_midterm_date_to">
                                    Fecha de Finalización
                                </label>
                                <input class="form-control col-md-7 col-xs-12" name="first_midterm_date_to" type="date" value="{{ old('first_midterm_date_to') }}">
                                </input>
                            </div>
                            <h4>SegundoParcial</h4>

			                  <div class="form-group col-sm-6">
                                <label class="control-label" for="second_midterm_date_from">
                                    Fecha de Inicio
                                </label>
                                <input class="form-control col-md-7 col-xs-12" name="second_midterm_date_from" type="date" value="{{ old('second_midterm_date_from') }}">
                                </input>
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="control-label" for="second_midterm_date_to">
                                    Fecha de Finalización
                                </label>
                                <input class="form-control col-md-7 col-xs-12" name="second_midterm_date_to" type="date" value="{{ old('second_midterm_date_to') }}">
                                </input>
                            </div>
                            <h4>Practicas</h4>

                            <div class="form-group col-sm-6">
                                <label class="control-label" for="pratice_score_date_from">
                                    Fecha de Inicio
                                </label>
                                <input class="form-control col-md-7 col-xs-12" name="pratice_score_date_from" type="date" value="{{ old('pratice_score_date_from') }}">
                                </input>
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="control-label" for="pratice_score_date_to">
                                    Fecha de Finalización
                                </label>
                                <input class="form-control col-md-7 col-xs-12" name="pratice_score_date_to" type="date" value="{{ old('pratice_score_date_to') }}">
                                </input>
                            </div>
                            <h4>ExamenFinal</h4>

                            <div class="form-group col-sm-6">
                                <label class="control-label" for="final_exam_date_from">
                                    Fecha de Inicio
                                </label>
                                <input class="form-control col-md-7 col-xs-12" name="final_exam_date_from" type="date" value="{{ old('final_exam_date_from') }}">
                                </input>
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="control-label" for="final_exam_date_to">
                                    Fecha de Finalización
                                </label>
                                <input class="form-control col-md-7 col-xs-12" name="final_exam_date_to" type="date" value="{{ old('final_exam_date_to') }}">
                                </input>
                            </div>
			                    {!! Form::submit('Guardar',['class' => 'btn btn-primary btn-block']) !!}
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
