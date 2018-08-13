<div class="input-group">
	{!!Form::open(['method'=>'GET','url'=>'users_s','role'=>'search'])!!}
	<div class="input-group-btn">
		<input type="text" class="form-control" name="usersSearch" placeholder="Buscar por nombre y apellido">
		{!! Form::submit('Buscar', ['class' => 'btn btn-danger']) !!}
	</div>
	{!!Form::close()!!}
</div>