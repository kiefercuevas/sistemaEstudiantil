<fieldset class="col-sm-10 col-sm-offset-1">
    <!-- Form Name -->
    <!-- Prepended text-->
    {!!Form::token()!!}
    <h4>
        Información personal de la materia
    </h4>

    <div class="form-group col-sm-4">
        <label class="control-label" for="code_subject">
            Codigo de la Materia
        </label>
        {{ Form::text('code_subject',null,['class'=>'form-control','placeholder'=>"Ingrese el codigo de la materia"]) }}
    </div>
    <div class="form-group col-sm-4">
        <label class="control-label" for="subject">
            Materia
        </label>
        {{ Form::text('subject',null,['class'=>'form-control','placeholder'=>"Ingrese la materia"]) }}
    </div>
    
     <div class="form-group col-sm-4">
        <label class="control-label" for="credits">
            Creditos
        </label>
        {{ Form::text('credits',null,['class'=>'form-control','placeholder'=>"Ingrese los creditos de la materia"]) }}
    </div>  
   
 
    {!! Form::submit('Crear materia',['class' => 'btn btn-primary btn-block']) !!}
    <br/>
</fieldset>


@section('script')

@endsection
