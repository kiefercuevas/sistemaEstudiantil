<div class="input-group">
	{!!Form::open(['method'=>'GET','url'=>'teachers_s','role'=>'search'])!!}
	<div class="input-group-btn">
		<input type="text" class="form-control" name="teachersSearch" placeholder="Buscar por nombre y apellido">
		{!! Form::submit('Buscar', ['class' => 'btn btn-danger']) !!}
		
	</div>
	<!--el select con un array asociativo para los diferentes valores que obtendremos de la url
	al enviar el metodo submit-->
	{{ Form::select('Status', ['All'=>'Todos',1=>'Activo',0=>'Inactivo']) }}
	<!--se agrego el form::close para cerrar el formulario-->
	{{ Form::close() }}
</div>