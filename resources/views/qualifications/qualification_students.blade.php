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

@if (count($alumnos) > 0 && count($fecha) > 0)
<div class="table-responsive">
    <table class="table table-striped jambo_table bulk_action">
        <thead>
            <tr class="headings">
                <th>
                    #
                </th>
                <th class="column-title">
                    PrimerParcial
                </th>
                <th class="column-title">
                    SegundoParcial
                </th>
                <th class="column-title">
                    Practicas
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
            <?php $contador++?>
            <tr class="even pointer">
                <td class="a-center ">
                    {{$contador}}
                </td>
                <td class=" ">

                {!! link_to_route('primerParcial.edit','PrimerParcial',$parameters = [$seccionID], $attributes = ['class' => 'btn btn-primary btn-xs']) !!}
                </td>
                <td class=" ">
                    {!! link_to_route('segundoParcial.edit','SegundoParcial',$parameters = [$seccionID], $attributes = ['class' => 'btn btn-primary btn-xs']) !!}
                </td>
                <td class=" ">
                   {!! link_to_route('practicas.edit','Practicas',$parameters = [$seccionID], $attributes = ['class' => 'btn btn-primary btn-xs']) !!}
                </td>
                <td class=" ">
                   {!! link_to_route('examenFinal.edit','ExamenFinal',$parameters = [$seccionID], $attributes = ['class' => 'btn btn-primary btn-xs']) !!}

                @if($time >= $fecha->first_midterm_date_from   && $time <= $fecha->first_midterm_date_to)
                {!! link_to_route('primerParcial.edit','PrimerParcial',$parameters = [$seccionID], $attributes = ['class' => 'btn btn-primary btn-xs']) !!}
                @else
                <span class="btn btn-primary btn-xs" disabled>
                    PrimerParcial
                </span>
                @endif
                </td>

                <td class=" ">
                @if($time >= $fecha->second_midterm_date_from   && $time <= $fecha->second_midterm_date_to)
                    {!! link_to_route('segundoParcial.edit','SegundoParcial',$parameters = [$seccionID], $attributes = ['class' => 'btn btn-primary btn-xs']) !!}
                @else
                <span class="btn btn-primary btn-xs" disabled>
                    SegundoParcial
                </span>
                @endif
                </td>
                <td class=" ">
                 @if($time >= $fecha->pratice_score_date_from   && $time <= $fecha->pratice_score_date_to)
                   {!! link_to_route('practicas.edit','Practicas',$parameters = [$seccionID], $attributes = ['class' => 'btn btn-primary btn-xs']) !!}
                @else
                <span class="btn btn-primary btn-xs" disabled>
                    Practicas
                </span>
                @endif
                </td>
                <td class=" ">
                 @if($time >= $fecha->final_exam_date_from   && $time <= $fecha->final_exam_date_to)
                   {!! link_to_route('examenFinal.edit','ExamenFinal',$parameters = [$seccionID], $attributes = ['class' => 'btn btn-primary btn-xs']) !!}
                @else
                <span class="btn btn-primary btn-xs" disabled>
                    ExamenFinal
                </span>
                @endif
>>>>>>> 27559091baa02437f32ef1cf98d3258e526e4ed9
                </td>
                 
            </tr>
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