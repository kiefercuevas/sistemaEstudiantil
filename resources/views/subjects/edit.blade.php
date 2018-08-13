@extends('layouts.landingPage')
@section('title', 'Materias')
@section('title-content', 'Editar Materia')
@section('content')

<div class="jumbotron main" id="content">
    <h1 class="text-center padding ">
        Materia
    </h1>
    <div class="container">
        <div class="row">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <h2 class="panel-title">
                        Editar Materia
                    </h2>
                </div>
                <div class="panel-body">
                    @include('alerts.requets')
                    {{ Form::model($subjects,['route'=>['subjects.update', $subjects->id, 'method'=>'POST']]) }}

                        {{ method_field('PUT') }}
						@include('forms.form_subject');
						{!! Form::close() !!}
                    <hr>
                    </hr>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
