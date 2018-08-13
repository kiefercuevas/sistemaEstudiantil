@extends('layouts.landingPage')
@section('title', 'Aulas')
@section('title-content', 'Crear Aula')

@section('content')
<div class="jumbotron main" id="content">
    <h1 class="text-center padding ">
        Aula
    </h1>
    <div class="container">
        <div class="row">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <h2 class="panel-title">
                        Crear Aula
                    </h2>
                </div>
                <div class="panel-body">
                    @include('alerts.requets')
                    {{ Form::open(['route'=>'classrooms.store', 'method'=>'POST']) }}
@include('forms.form_classroom')
@include('forms.alerts')

{!! Form::close() !!}
                    <hr>
                    </hr>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

