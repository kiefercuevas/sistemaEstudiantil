@extends('layouts.landingPage')
@section('title', 'Selección de asignaturas')
@section('title-content', 'Selección')
@section('content')
@if(count($sections) > 0)
<div class="table-responsive">
	@if(Session::has('message2'))

	    <div class="alert alert-danger">
	      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	      {{ session::get('message2') }}
	    </div>
	@elseif(Session::has('message'))

	    <div class="alert alert-danger">
	      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	      {{ session::get('message') }}
	    </div>

  	@endif
	{!!Form::open(['route' => 'inscribed.store', 'method' => 'POST'])!!}
		{!!Form::token()!!}
		<input type="hidden" name="id_student" value="{{$student->id}}" id="id_student">
	  <table class="table table-striped jambo_table bulk_action">
	    <thead>
	      <tr class="headings">
	        <th>
	          Acción
	        </th>
	        <th class="column-title">Sec. </th>
	        <th class="column-title">Aula. </th>
	        <th class="column-title">Codigo. </th>
	        <th class="column-title">Descripción. </th>
	        <th class="column-title">Cupos. </th>
	        <th class="column-title">Créd. </th>
	        <th class="column-title">Lunes. </th>
	        <th class="column-title">Martes. </th>
	        <th class="column-title">Miercoles. </th>
	        <th class="column-title">Jueves. </th>
	        <th class="column-title">Viernes. </th>
	        <th class="column-title">Sabados. </th>
	        </th>
	      </tr>
	    </thead>

	    <tbody>
	    	@for ($i = 0; $i < count($sections); $i++)
	    	@foreach($sections[$i] as $sec)
	    	
		      <tr class="even pointer">
		        <td class="a-center ">
							
		          <input type="checkbox" name="subject_selected[]" value="{{$sec->id}}" 
							id="subject_selected">
						
		        </td>
		        <td class="text-center">{{$sec->section}}</td>
		        <td class=" ">{{$sec->location}} </td>
		        <td class=" ">{{$sec->code_subject}}</td>
		        <td class=" ">{{$sec->subject}}</td>
		        <td class=" ">/ {{$sec->quota}}</td>
		        <td class="text-center">{{$sec->credits}}</td>
		        @if($sec->day_one == 'Lunes')
		        <td class=" ">{{$sec->time_first}} - {{$sec->time_last}}</td>
		        @elseif($sec->day_two == 'Lunes')
		        <td class=" ">{{$sec->second_time_first}} - {{$sec->second_time_last}}</td>
		        @else
		        <td class="text-center">-</td>
		        @endif
		        @if($sec->day_one == 'Martes')
		        <td class=" ">{{$sec->time_first}} - {{$sec->time_last}}</td>
		        @elseif($sec->day_two == 'Martes')
		        <td class=" ">{{$sec->second_time_first}} - {{$sec->second_time_last}}</td>
		        @else
		        <td class="text-center">-</td>
		        @endif
		        @if($sec->day_one == 'Miercoles')
		        <td class=" ">{{$sec->time_first}} - {{$sec->time_last}}</td>
		        @elseif($sec->day_two == 'Miercoles')
		        <td class=" ">{{$sec->second_time_first}} - {{$sec->second_time_last}}</td>
		        @else
		        <td class="text-center">-</td>
		        @endif
		        @if($sec->day_one == 'Jueves')
		        <td class=" ">{{$sec->time_first}} - {{$sec->time_last}}</td>
		        @elseif($sec->day_two == 'Jueves')
		        <td class=" ">{{$sec->second_time_first}} - {{$sec->second_time_last}}</td>
		        @else
		        <td class="text-center">-</td>
		        @endif
		        @if($sec->day_one == 'Viernes')
		        <td class=" ">{{$sec->time_first}} - {{$sec->time_last}}</td>
		        @elseif($sec->day_two == 'Viernes')
		        <td class=" ">{{$sec->second_time_first}} - {{$sec->second_time_last}}</td>
		        @else
		        <td class="text-center">-</td>
		        @endif
		        @if($sec->day_one == 'Sabado')
		        <td class=" ">{{$sec->time_first}} - {{$sec->time_last}}</td>
		        @elseif($sec->day_two == 'Sabado')
		        <td class=" ">{{$sec->second_time_first}} - {{$sec->second_time_last}}</td>
		        @else
		        <td class="text-center">-</td>
		        @endif
		      </tr>
	    	@endforeach
	    	@endfor
	    </tbody>
	  </table>
</div>
<div class="text-right">
	<a href="/students" class="btn btn-default">Volver atras</a>
	{!!Form::submit('Grabar',['class'=>'btn btn-success'])!!}
	{!!Form::close()!!}
</div>
@else
<div class="container" id="error">
        <figure id="img-error">
          <img src="img/sad-face.png" alt="sad-face">
        </figure>
        <h2 class="text-center">Oops, no se encontro ningun dato.</h2>
    </div>
@endif

@endsection

@section('script')
	<script src="{{ URL::asset('js/script_offers_student.js') }}"></script>
@endsection