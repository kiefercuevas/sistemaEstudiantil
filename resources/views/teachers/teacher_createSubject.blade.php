@extends('layouts.landingPage')
@section('title', 'Profesores')
@section('title-content', 'Materias')
@section('content')


  @if (count($subjects) > 0)
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
	{!!Form::open(['route' => ['materiasProfesor.update',$id], 'method' => 'PUT'])!!}
		{!!Form::token()!!}  
      <div class="table-responsive">
        <table class="dataTables_wrapper form-inline dt-bootstrap no-footer jambo_table bulk_action display "  id='table_id'>
          <thead>
            <tr class="headings">
              <th>#</th>
              <th class="column-title">asignar</th>
              <th class="column-title">codigo </th>
              <th class="column-title">Materia</th>
              <th class="bulk-actions" colspan="7">
              <th class="column-title no-link last remove"><span class="nobr">Acción</span>
              </th>
              <th class="bulk-actions" colspan="7">
                <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
              </th>
            </tr>
          </thead>

          <tbody>
            <?php $contador = 0;?>
            @foreach ($subjects as $subject)			
              <?php $contador++?>
              <tr class="even pointer">		
                <td class="a-center ">{{$contador}}</td>
                <td class=" "><input type="checkbox" name="subject_selected[]" value="{{$subject->id}}" 
			           id="subject_selected" ></td>
                <td class=" ">{{$subject->code_subject}}</td>
                <td class=" ">{{$subject->subject}}</td>
                <td class="last remove">

                </td>
              </tr>
              
            @endforeach
            
          </tbody>
        </table>
       
      </div>
      <br>
    <div class="text-center">
	{!!Form::submit('Grabar',['class'=>'btn btn-success'])!!}
	{!!Form::close()!!}
</div>
     
@else
@include('forms.teacherSearch',['url'=>'teachers','link'=>'teachers'])
    <div class="container" id="error">
        <figure id="img-error">
          <img src="img/sad-face.png" alt="sad-face">
        </figure>
        <h2 class="text-center">Oops, no se encontro ningun dato.</h2>
    </div>

@endif


@endsection
