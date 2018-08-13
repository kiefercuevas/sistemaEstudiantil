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
                        Editar Periodo Academico
                    </h2>
                </div>
                <div class="panel-body">
                    @include('alerts.requets')
                    {{ Form::model($academic_periods,['route'=>['academic_periods.update', $academic_periods->id, 'method'=>'POST']]) }}
                        {{ method_field('PUT') }}
                        <fieldset class="col-sm-10 col-sm-offset-1">
                            <div class="form-group col-sm-12">
                                <label class="control-label" for="academic_period">
                                    Periodo Academico
                                </label>
                                {{ Form::text('academic_period',null,['class'=>'form-control col-md-7 col-xs-12','placeholder'=>"Ingrese el periodo academico", 'disabled'=>'disabled']) }}
                            </div>
                            @include('forms.form_academic_period')
                        </fieldset>
                    {!! Form::close() !!}
                    <hr>
                    </hr>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
