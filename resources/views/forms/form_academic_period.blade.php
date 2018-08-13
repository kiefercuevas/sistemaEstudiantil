
    <!-- Form Name -->
    <!-- Prepended text-->
    {!!Form::token()!!}
    <h4>
        Información personal del periodo academico
    </h4>
    
    <div class="form-group col-sm-6">
        <label class="control-label" for="nombres">
            Fecha de Inicio
        </label>
        <input class="form-control col-md-7 col-xs-12" name="date_first" type="date">
        </input>
    </div>
    <div class="form-group col-sm-6">
        <label class="control-label" for="nombres">
            Fecha de Finalización
        </label>
        <input class="form-control col-md-7 col-xs-12" name="date_last" type="date">
        </input>
    </div>
    <div class="form-group col-sm-6">
        {!!Form::label('status','Estatus del periodo academico',['class'=>'control-label'])!!}<br>
        {!!Form::radio('status', '1')!!} Activo.
        <br>
        {!!Form::radio('status', '0')!!} Inactivo.
    </div>
    <!-- Button -->
    {!! Form::submit('Crear Periodo Academico',['class' => 'btn btn-primary btn-block']) !!}
    <br>
    </br>
    @include('forms.alerts')
