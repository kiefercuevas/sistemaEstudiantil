<div class="input-group">
    {!!Form::open(['method'=>'GET','url'=>'sections_s','role'=>'search'])!!}
    <div class="input-group-btn">
        <input class="form-control" name="sectionSearch" placeholder="Buscar por numero de sección" type="text">
            {!! Form::submit('Buscar', ['class' => 'btn btn-danger']) !!}
        </input>
    </div>
    {!!Form::close()!!}
</div>