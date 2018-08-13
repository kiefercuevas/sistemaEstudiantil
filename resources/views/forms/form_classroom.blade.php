<fieldset class="col-sm-10 col-sm-offset-1">
    <!-- Form Name -->
    <!-- Prepended text-->
    {!!Form::token()!!}
    <h4>
        Información personal del Aula
    </h4>
    <div class="form-group col-sm-6">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="academic_period">
            Aula
        </label>
        {{ Form::text('location',null,['class'=>'form-control col-md-7 col-xs-12','placeholder'=>"Ingrese el aula"]) }}
    </div>
    <div class="form-group col-sm-6">
        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="academic_period">
            Capacidad
        </label>
        {{ Form::text('capacity',null,['class'=>'form-control col-md-7 col-xs-12','placeholder'=>"Ingrese la capacidad del aula"]) }}
    </div>
    <!-- Button -->
    {!! Form::submit('Crear Aula',['class' => 'btn btn-primary btn-block']) !!}
    <br>
    </br>
</fieldset>
@include('forms.alerts')
