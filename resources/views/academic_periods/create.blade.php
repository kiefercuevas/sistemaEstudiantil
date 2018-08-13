@extends('layouts.landingPage')
@section('title', 'Periodo Academico')
@section('title-content', 'Periodo Academico')
@section('content')

<div class="jumbotron main" id="content">
    <h1 class="text-center padding ">
        Periodo Academico
    </h1>
    <div class="container">
        <div class="row">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <h2 class="panel-title">
                        Crear Periodo Academico
                    </h2>
                </div>
                <div class="panel-body">
                    @include('alerts.requets')
                    {{ Form::open(['route'=>'academic_periods.store', 'method'=>'POST']) }}
@include('forms.form_academic_period')
{!! Form::close() !!}
                    <hr>
                    </hr>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
