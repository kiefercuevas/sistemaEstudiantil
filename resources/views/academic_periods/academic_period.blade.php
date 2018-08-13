@extends('layouts.landingPage')
@section('title', 'Periodo Academico')
@section('title-content', 'Periodo Academico')



@if(Session::has('message2'))
<div class="alert alert-warning">
    {{ session::get('message') }}
</div>
@endif

@section('content')
<div class="row padding">
    <div class="col-lg-4 col-md-4">
        <div class="input-group">
            @if (count($academic_periods) > 0)
@include('forms.search_academic_period',['url'=>'academic_periods','link'=>'academic_periods'])
@endif
        </div>
    </div>

    <div class="text-right ">
        {!!link_to('academic_periods/create', $title = '', $attributes = ['class' => 'fa fa-plus fa-3x pointer blackColor'], $secure = null)!!}
    </div>
</div>
@if(Session::has('message'))
<div class="alert alert-success">
    {{ session::get('message') }}
</div>
@endif
@if (count($academic_periods) > 0)
<div class="table-responsive">
    <table class="table table-striped jambo_table bulk_action" id="table_id">
        <thead>
            <tr class="headings">
                <th>
                    #
                </th>
                <th>
                    Periodo Academico
                </th>
                <th>
                    Fecha de Inicio
                </th>
                <th>
                    Fecha de Finalidad
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
            @foreach($academic_periods as $academic_period)
            <tr class="even pointer">
                <td>
                    {{ $academic_period->id }}
                </td>
                <td>
                    {{ $academic_period->academic_period }}
                </td>
                <td>
                    {{ $academic_period->date_first }}
                </td>
                <td>
                    {{ $academic_period->date_last }}
                </td>
                <td class=" last">
                    {{-- {!! link_to_route('employees.edit', $title = 'Ver', $parameters = $academic_period->id, $attributes = ['class' => 'btn btn-info btn-xs']) !!} --}}

                    {{-- {!! link_to_action('StudentsController@destroy', $title = 'Eliminar', $parameters = $academic_period->id, $attributes = ['class' => 'label label-danger']) !!} --}}
                    {!!Form::open(['route'=> ['academic_periods.destroy', $academic_period->id], 'method' => 'DELETE'])!!}
                             {!! link_to_route('academic_periods.edit', $title = 'Editar', $parameters = $academic_period->id, $attributes = ['class' => 'btn btn-warning btn-xs']) !!}
                        {!!Form::submit('Eliminar',['class' => 'btn btn-danger btn-xs'])!!}

                    {!!Form::close()!!}

                    {{-- {{ Form::open(['route'=>['academic_periods.destroy', $academic_period->id, 'method'=>'DELETE'], 'class'=>'form-horizontal form-label-left"']) }}
                    {!! link_to_route('academic_periods.edit', $title = 'Ver', $parameters = $academic_period->id, $attributes = ['class' => 'btn btn-info btn-xs']) !!}
                    {!! link_to_route('academic_periods.edit', $title = 'Editar', $parameters = $academic_period->id, $attributes = ['class' => 'btn btn-primary btn-xs']) !!}
                    <a data-target="#delete-modal" data-toggle="modal" href="#">
                        <span class="btn btn-danger btn-xs">
                            Eliminar
                        </span>
                    </a>
                    {{ Form::close() }}
                    @include('modals.delete_modal', ['r' => 'academic_periods.destroy', 'id' => $academic_period->id]) --}}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <button class="btn btn-default" onclick="window.print();">
        <i class="fa fa-print">
        </i>
        Print
    </button>
</div>
<div class="text-right">
    {{ $academic_periods->render() }}
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
