<fieldset class="col-sm-10 col-sm-offset-1">
    <!-- Form Name -->
    <!-- Prepended text-->
    {!!Form::token()!!}
    <h4>
        Información personal de la cita
    </h4>
    


    <div class="form-group col-sm-6">
                                    {!! Form::label('language', 'Idioma') !!}
                                    {!!Form::select('language',[
                                        'Ingles' => 'Ingles',
                                        'Frances' => 'Frances',
                                        
                                    ],null,['class' => 'form-control'])!!}
    </div>
     
    <div class="form-group col-sm-6">
        <label class="control-label" for="location">
            Ubicación
        </label>
        {{ Form::text('location',null,['class'=>'form-control','placeholder'=>"Ingrese la ubicación"]) }}

    </div>
     <div class="form-group col-sm-6">
         <label class="control-label" for="nombres">Fecha del examen</label>
         <input type="date" class="form-control" id="date" name="date" value="{{$language->date}}" min="2017-01-01">
         

    </div>
    
    <div class='form-group col-sm-6'>
                    <label for="date">Hora del Examen</label>
                    <div class="form-group">
                        <div class='input-group date' id='Datepicker'>
                            <input  type='text' class="form-control" name="time" value="{{$language->time}}"/>
                            <span class="input-group-addon">
                               <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
   
 
    {!! Form::submit('Crear Cita',['class' => 'btn btn-primary btn-block']) !!}
    <br/>
</fieldset>


@section('script')
@include('forms.alerts')

@endsection
