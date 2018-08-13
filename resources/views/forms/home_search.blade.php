<div class="input-group">

	{!!Form::open(['method'=>'GET','url'=>'home_s','role'=>'search'])!!}
	

	
  <div class="input-group-btn">
   <input type="text" class="form-control" name="query" placeholder="Buscar por nombre y apellido">
    <!-- Button and dropdown menu -->
		 <!-- Single button -->

	<select name="user" id="user" type="button" class="btn btn-default dropdown-toggle menu" data-toggle="dropdown">

<!--el select con un array asociativo para los diferentes valores que obtendremos de la url
	al enviar el metodo submit-->
	
		<option value="Profesor">Profesor</option>
		<option value="Estudiante">Estudiante</option>
		<option value="Empleado">Empleado</option>
	</select>

{!! Form::submit('Buscar', ['class' => 'btn btn-danger']) !!}
  </div>

	{{ Form::close() }}
</div>




