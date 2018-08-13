@extends('layouts.landingPage')
@section('title', 'Estudiantes')
@section('title-content', 'Estudiantes')
@section('content')



  @if(Session::has('message'))

    <div class="alert alert-success">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      {{ session::get('message') }}
    </div>
  @endif

@if (count($alumnos) > 0)
{!! Form::open(['route' => ['examenFinal.update', $id], 'method' => 'PUT']) !!}
<div class="table-responsive">
{!!Form::token()!!}
    <table class="table table-striped jambo_table bulk_action">
        <thead>
            <tr class="headings">
                <th>
                    #
                </th>
                <th class="column-title">
                    Nombres
                </th>
                <th class="column-title">
                    Apellidos
                </th>
                <th class="column-title">
                    identificacion
                </th>
                <th class="column-title">
                    ExamenFinal
                </th>
                <th class="bulk-actions" colspan="7">
                    <a class="antoo" style="color:#fff; font-weight:500;">
                        Bulk Actions (
                        <span class="action-cnt">
                        </span>
                        )
                        <i class="fa fa-chevron-down">
                        </i>
                    </a>
                </th>
            </tr>
        </thead>
        <tbody>
        <?php $contador = 0;?>
            @foreach ($alumnos as $alumno)
              <?php $contador++?>
            <tr class="even pointer">
                <td class="a-center ">
                    {{$contador}}
                </td>
                <td class=" " style="display: none;">
                <input class="form-control" type="text"  id="names" name="id[]" placeholder="" value='{{$alumno->id}}' readonly style="display: none;"> 
                </td>
                <td class=" ">
                <input class="form-control" type="text"  id="names" name="names[]" placeholder="" value='{{$alumno->names}}' readonly> 
                </td>
                <td class=" ">
                <input class="form-control" type="text"  id="names" name="last_name[]" placeholder="" value='{{$alumno->last_name}}' readonly>    
                </td>
                <td class=" ">
                <input class="form-control" type="text"  id="names" name="identity_card[]" placeholder="" value='{{$alumno->identity_card}}' readonly>         
                </td>
                <td class=" ">
                <input class="form-control" type="number"  min="0" max="20" id="final_exam" name="final_exam[]" placeholder="" value='{{$alumno->final_exam}}' >
                </td>
                
            </tr>
            @endforeach
        </tbody>
    </table>
    {!! Form::submit('Guardar',['class' => 'btn btn-primary btn-block']) !!}
    </div>

{!! Form::close() !!}
    @else
    <div class="container" id="error">
        <figure id="img-error">
          <img src="img/sad-face.png" alt="sad-face">
        </figure>
        <h2 class="text-center">Oops, no se encontro ningun dato.</h2>
    </div>

  @endif


@endsection