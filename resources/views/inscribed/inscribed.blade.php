@extends('layouts.landingPage')
@section('title','Selección')
@section('title-content','Selección de Asignaturas')
@section('content')
	<div class="table-responsive">
      <table class="table table-striped jambo_table bulk_action">
        <thead>
          <tr class="headings">
          	<th class="column-title">#</th>
            <th class="column-title">Numero de Sección </th>
            <th class="column-title">Materia</th>
            <th class="column-title">Horario</th>
            <th class="column-title">Tanda</th>
            <th class="column-title">Cupo</th>
            <th class="column-title">Aula </th>
            <th class="column-title no-link last"><span class="nobr">Acción</span>
            </th>
            <th class="bulk-actions" colspan="7">
              <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
            </th>
          </tr>
        </thead>

        <tbody>
        <?php $contador =0;?>
        @foreach($sections as $sec)
        	<?php $contador++;?>
          <tr class="even pointer">
          	<td class=" ">{{$contador}}</td>
            <td class=" ">{{$sec->section}}</td>
            <td class=" ">{{$sec->subject}}</td>
            <td class=" ">{{$sec->time_first}} {{$sec->time_first}} {{$sec->time_first}}</td>
            <td class=" ">John Blank L</td>
            <td class=" ">Paid</td>
            <td class="a-right a-right ">$7.45</td>
            <td>{!! link_to_route('inscribed.show', $title = 'Ver Sección', $parameters = $sec->id, $attributes = ['class' => 'btn btn-primary btn-xs']) !!}</td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>

@endsection