
@extends('layouts.landingPage')
@section('title', 'Materias')
@section('title-content', 'Crear Materia')
@section('content')

<div class="jumbotron main" id="content">
    <h1 class="text-center padding ">
        Materias
    </h1>
    <div class="container">
        <div class="row">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <h2 class="panel-title">
                        Crear Materia
                    </h2>
                </div>
                <div class="panel-body">
                    @include('alerts.requets')
                    {{ Form::open(['route'=>'subjects.store', 'method'=>'POST']) }}
						@include('forms.form_subject');
                        {!! Form::close() !!}
                    </hr>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

