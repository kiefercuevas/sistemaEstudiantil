@extends('layouts.landingPage')
@section('title', 'Secciones')
@section('title-content', 'Secciones')
@section('content')


  @if(Session::has('message'))

    <div class="alert alert-success">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      {{ session::get('message') }}
    </div>
  @endif

@if (count($sections) > 0)
<div class="table-responsive">
    <table class="table table-striped jambo_table bulk_action">
        <thead>
            <tr class="headings">
                <th>
                    #
                </th>
                <th class="column-title">
                    Sección
                </th>
                <th class="column-title">
                    Profesor
                </th>
                <th class="column-title">
                    Cupos
                </th>
                <th class="column-title">
                    Asignatura
                </th>
                <th class="column-title">
                    Aula
                </th>
                <th class="column-title">
                    Dias
                </th>
                <th class="column-title">
                    Hora
                </th>
                <th class="column-title">
                    Hora2
                </th>
                <th class="column-title">
                    Tanda
                </th>

                <th class="column-title no-link last">
                    <span class="nobr">
                        Acción
                    </span>
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
            @foreach ($sections as $section)
            <?php $contador++?>
             <?php
            $timelast       = $section->time_last;
            $secondTimeLast = $section->second_time_last;
            $timeToAdd = 1;

            $timelastHourToSecond       = strtotime($timelast);
            $secondTimelastHourToSecond = strtotime($secondTimeLast);

            $minutesToAdd = $timeToAdd * 60;

            $timeLastNewHour       = date('H:i:s', $timelastHourToSecond + $minutesToAdd);
            $secondTimelastNewHour = date('H:i:s', $secondTimelastHourToSecond + $minutesToAdd);
        ?>
            <tr class="even pointer">
                <td class="a-center ">
                    {{$contador}}
                </td>
                <td class=" ">
                    {{$section->section}}
                </td>
                 <td class=" ">
                    {{$section->names}}
                </td>
                <td class=" ">
                    {{$section->quota}}
                </td>
                <td class=" ">
                    {{$section->subject}}
                </td>
                <td class=" ">
                    {{$section->location}}
                </td>
                <td class=" ">
                    {{$section->day_one}} / {{$section->day_two}}
                </td>
                <td class=" ">
                    {{$section->time_first}} / {{$timeLastNewHour }}
                </td>
                <td class=" ">
                @if(empty($section->second_time_first) && empty($section->second_time_last))
                    NULL / NULL
                @else
                {{$section->second_time_first}} / {{$secondTimelastNewHour}}
                 @endif    
                </td>
                <td class=" ">
                    {{$section->shift}}
                </td>
               
                <td class=" last">
                    {{--{!! link_to_route('sections.edit', $title = 'Ver', $parameters = $section->id, $attributes = ['class' => 'label label-info']) !!}--}}
                  {!! link_to_route('qualifications.show', $title = 'Calificar', $parameters = $section->id, $attributes = ['class' => 'btn btn-primary']) !!}
            
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
    @else
    <div class="container" id="error">
        <figure id="img-error">
            <img alt="sad-face" src="img/sad-face.png">
            </img>
        </figure>
        <h2 class="text-center">
            Oops, no se encontro ningun dato.
        </h2>
    </div>
    @endif

@endsection