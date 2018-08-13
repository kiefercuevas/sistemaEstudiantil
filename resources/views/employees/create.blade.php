
@extends('layouts.landingPage')
@section('title', 'Empleados')
@section('title-content', 'Crear Empleado')
@section('content')

<div class="jumbotron main" id="content">
    <h1 class="text-center padding ">
        Empleado
    </h1>
    <div class="container">
        <div class="row">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <h2 class="panel-title">
                        Crear Empleado
                    </h2>
                </div>
                <div class="panel-body">
                    @include('alerts.requets')
                    {{ Form::open(['route'=>'employees.store', 'method'=>'POST']) }}
						@include('forms.form_employee')
						{!! Form::close() !!}
                    <hr>
                    </hr>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
