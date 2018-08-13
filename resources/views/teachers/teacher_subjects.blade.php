@extends('layouts.landingPage')
@section('title', 'Profesores')
@section('title-content', 'Materias')
@section('content')

  @if(Session::has('message'))
    <div class="alert alert-success">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      {{ session::get('message') }}
    </div>
  @endif
<div class="col-lg-12 text-right ">
      {!!link_to_route('materiasProfesor.edit', $title='', $parameters = $id, $attributes = ['class' => 'fa fa-plus fa-3x pointer blackColor'])!!}
    </div>
  </div>

  @if (count($subjects) > 0)
        
      <div class="table-responsive">
        <table class="dataTables_wrapper form-inline dt-bootstrap no-footer jambo_table bulk_action display "  id='table_id'>
          <thead>
            <tr class="headings">
              <th>#</th>
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
                <td class=" ">{{$subject->code_subject}}</td>
                <td class=" ">{{$subject->subject}}</td>
                <td class="last remove">

                 
                   
                    {!!Form::open(['route'=> ['materiasProfesor.destroy', $subject->id], 'method' => 'DELETE'])!!}
                        {!!Form::submit('Eliminar',['class' => 'btn btn-danger btn-xs'])!!}
                    {!!Form::close()!!}
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
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