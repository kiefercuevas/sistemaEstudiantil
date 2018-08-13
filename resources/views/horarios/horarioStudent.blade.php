@extends('layouts.landingPage')
@section('title', 'HorarioEstudiante')
@section('title-content', 'Horario')
@section('content')


  @if(Session::has('message'))

    <div class="alert alert-success">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      {{ session::get('message') }}
    </div>
  @endif
@if (count($sections) > 0)
<table class="table table-striped jambo_table bulk_action" id="table_id">
	    <thead>
	      <tr class="headings">
	        <th class="column-title text-center">Lunes. </th>
	        <th class="column-title text-center">Martes. </th>
	        <th class="column-title text-center">Miercoles. </th>
	        <th class="column-title text-center">Jueves. </th>
	        <th class="column-title text-center">Viernes. </th>
	        <th class="column-title text-center">Sabados. </th>
	        </th>
	      </tr>
	    </thead>

	    <tbody>
	    	@foreach($sections as $sec)
		      <tr class="even pointer">
		        @if($sec->day_one == 'Lunes')
		        <td class="text-center">
                <div>
                {{$sec->code_subject}}<br>
                {{$sec->location}}<br>
                {{$sec->time_first}} - {{$sec->time_last}}<br>
                {{$sec->section}}
                </div>
                </td>
		        @elseif($sec->day_two == 'Lunes')
		        <td class="text-center ">
                <div class="">
                {{$sec->code_subject}}<br>
                {{$sec->location}}<br>
                {{$sec->second_time_first}} - {{$sec->second_time_last}}<br>
                {{$sec->section}}
                </div>
                </td>
		        @else
		        <td class="text-center">-</td>
		        @endif
		        @if($sec->day_one == 'Martes')
		        <td class="text-center">
                <div>
                
                {{$sec->code_subject}}<br>
                {{$sec->location}}<br>
                {{$sec->time_first}} - {{$sec->time_last}}<br>
                {{$sec->section}}
                </div>
                </td>
		        @elseif($sec->day_two == 'Martes')
		         <td class=" text-center">
                <div>
                
                {{$sec->code_subject}}<br>
                {{$sec->location}}<br>
                {{$sec->second_time_first}} - {{$sec->second_time_last}}<br>
                {{$sec->section}}
                </div>
                </td>
		        @else
		        <td class="text-center">-</td>
		        @endif
		        @if($sec->day_one == 'Miercoles')
		        <td class="text-center">
                <div>
                
                {{$sec->code_subject}}<br>
                {{$sec->location}}<br>
                {{$sec->time_first}} - {{$sec->time_last}}<br>
                {{$sec->section}}
                </div>
                </td>
		        @elseif($sec->day_two == 'Miercoles')
		         <td class="text-center ">
                <div>
                
                {{$sec->code_subject}}<br>
                {{$sec->location}}<br>
                {{$sec->second_time_first}} - {{$sec->second_time_last}}<br>
                {{$sec->section}}
                </div>
                </td>
		        @else
		        <td class="text-center">-</td>
		        @endif
		        @if($sec->day_one == 'Jueves')
		        <td class="text-center">
                <div>
                
                {{$sec->code_subject}}<br>
                {{$sec->location}}<br>
                {{$sec->time_first}} - {{$sec->time_last}}<br>
                {{$sec->section}}
                </div>
                </td>
		        @elseif($sec->day_two == 'Jueves')
		         <td class="text-center ">
                <div>
                
                {{$sec->code_subject}}<br>
                {{$sec->location}}<br>
                {{$sec->second_time_first}} - {{$sec->second_time_last}}<br>
                {{$sec->section}}
                </div>
                </td>
		        @else
		        <td class="text-center">-</td>
		        @endif
		        @if($sec->day_one == 'Viernes')
		         <td class="text-center">
                <div>
                
                {{$sec->code_subject}}<br>
                {{$sec->location}}<br>
                {{$sec->time_first}} - {{$sec->time_last}}<br>
                {{$sec->section}}
                </div>
                </td>
		        @elseif($sec->day_two == 'Viernes')
		        <td class="text-center ">
                <div>
                
                {{$sec->code_subject}}<br>
                {{$sec->location}}<br>
                {{$sec->second_time_first}} - {{$sec->second_time_last}}<br>
                {{$sec->section}}
                </div>
                </td>
		        @else
		        <td class="text-center">-</td>
		        @endif
		        @if($sec->day_one == 'Sabado')
		         <td class="text-center">
                <div>
                
                {{$sec->code_subject}}<br>
                {{$sec->location}}<br>
                {{$sec->time_first}} - {{$sec->time_last}}<br>
                {{$sec->section}}
                </div>
                </td>
		        @elseif($sec->day_two == 'Sabado')
		         <td class="text-center ">
                <div>
                
                {{$sec->code_subject}}<br>
                {{$sec->location}}<br>
                {{$sec->second_time_first}} - {{$sec->second_time_last}}<br>
                {{$sec->section}}
                </div>
                </td>
		        @else
		        <td class="text-center">-</td>
		        @endif
		      </tr>
	    	@endforeach
	    	
	    </tbody>
	  </table>
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
	<script>
$(document).ready(function() {
    $('#table_id').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'print'
        ]
    } );
} );
  </script>
@endsection