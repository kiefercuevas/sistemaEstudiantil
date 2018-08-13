@extends('layouts.landingPage');

@section('title', 'Lista estudiantes')
@section('title-content', 'lista estudiantes')
@section('content')
@if(Session::has('message'))
<div class="alert alert-danger" id='Danger'>
    {{ session::get('message') }}
</div>
@endif
	<div id="content" class="jumbotron main">
		<h1 class="text-center padding ">Lista estudiantes</h1>
		<div class="container">
			<div class="row">
				<div class="panel panel-danger">
					<div class="panel-heading">
						<h2 class="panel-title">Lista estudiantes</h2>
					</div>
					<div class="panel-body">
						@include('alerts.requets')

						{{ Form::open(['route' => 'listaEstudiantes.store', 'method' => 'POST','files' => true]) }}
			                <fieldset class="col-sm-10 col-sm-offset-1">
			                    <!-- Form Name -->
			                    <!-- Prepended text-->
	
			                    {!!Form::token()!!}

								<h4>Subir lista</h4>
                                <div class="form-group">
                                <label for="studentList">lista</label>
                                <input type="file" class="form-control-file" id="studentList" Name="studentList" aria-describedby="fileHelp">
                                </div>
                                
			                    {!! Form::submit('Guardar',['class' => 'btn btn-primary btn-block ']) !!}
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
