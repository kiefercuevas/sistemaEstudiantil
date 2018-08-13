<div class="input-group">
    {!!Form::open(['method'=>'GET','url'=>'classrooms_s','role'=>'search'])!!}
    <div class="input-group-btn">
        <input class="form-control" name="classroomSearch" placeholder="Buscar por aula" type="text">
            {!! Form::submit('Buscar', ['class' => 'btn btn-danger']) !!}
        </input>
    </div>
    {!!Form::close()!!}
</div>