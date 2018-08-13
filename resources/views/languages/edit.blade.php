
@extends('layouts.landingPage')
@section('title', 'Citas')
@section('title-content', 'Editar Cita')
@section('content')

<div class="jumbotron main" id="content">
    <h1 class="text-center padding ">
        Citas de Idiomas
    </h1>
    <div class="container">
        <div class="row">
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <h2 class="panel-title">
                        Editar Cita
                    </h2>
                </div>
                <div class="panel-body">
                    @include('alerts.requets')
                    {{ Form::model($language,['route'=>['idioma_update_path', $language->id, 'method'=>'POST']]) }}

                        {{ method_field('PUT') }}
						@include('forms.form_language');
                    {!! Form::close() !!}
                    </hr>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
