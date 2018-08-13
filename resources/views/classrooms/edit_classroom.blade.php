@extends('layouts.landingPage')
@section('title', 'Aulas')
@section('title-content', 'Aulas')
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
                        Editar Aula
                    </h2>
                </div>
                <div class="panel-body">
                    @include('alerts.requets')
                    {{ Form::model($classrooms,['route'=>['classrooms.update', $classrooms->id, 'method'=>'POST']]) }}
{{ method_field('PUT') }}
@include('forms.form_classroom')
{!! Form::close() !!}
                    <hr>
                    </hr>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
