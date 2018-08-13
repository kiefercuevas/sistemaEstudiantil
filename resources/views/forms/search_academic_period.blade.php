<div class="input-group">
    {!!Form::open(['method'=>'GET','url'=>'academic_periods_s','role'=>'search'])!!}
    <div class="input-group-btn">
        <input class="form-control" name="academic_periodSearch" placeholder="Buscar por periodo academico" type="text">
            {!! Form::submit('Buscar', ['class' => 'btn btn-danger']) !!}
        </input>
    </div>
</div>