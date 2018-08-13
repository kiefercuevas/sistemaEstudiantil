@extends('layouts.landingPage')
@section('title', 'Aulas')

@section('title-content', 'Aulas')
@section('content')
@if(Session::has('message'))
<div class="alert alert-success" id="Success">
    {{ session::get('message') }}
</div>
@endif

<div class="row padding">
    <div class="col-lg-4 col-md-4">
        <div class="input-group">
            @if (count($classrooms) > 0)
    @include('forms.search_classroom',['url'=>'classrooms','link'=>'classrooms'])
@endif
        </div>
    </div>
    <div class="text-right ">
        {!!link_to('classrooms/create', $title = '', $attributes = ['class' => 'fa fa-plus fa-3x pointer blackColor'], $secure = null)!!}
    </div>
</div>
@if (count($classrooms) > 0)
<div class="table-responsive">
    <table class="table table-striped jambo_table bulk_action" id="table_idclas">
        <thead>
            <tr class="headings">
                <th>
                    #
                </th>
                <th class="column-title">
                    Aula
                </th>
                <th class="column-title">
                    Capacidad
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
            @foreach($classrooms as $classroom)
            <?php $contador++;?>
            <tr class="even pointer">
                <td>
                    {{ $contador }}
                </td>
                <td>
                    {{ $classroom->location }}
                </td>
                <td>
                    {{ $classroom->capacity }} Estudiantes
                </td>
                <td class=" last">

                    {{-- {!! link_to_route('employees.edit', $title = 'Ver', $parameters = $students->id, $attributes = ['class' => 'btn btn-info btn-xs']) !!} --}}

                    {{-- {!! link_to_action('StudentsController@destroy', $title = 'Eliminar', $parameters = $students->id, $attributes = ['class' => 'label label-danger']) !!} --}}
                    {!!Form::open(['route'=> ['classrooms.destroy', $classroom->id], 'method' => 'DELETE'])!!}
                    {!! link_to_route('classrooms.edit', $title = 'Editar', $parameters = $classroom->id, $attributes = ['class' => 'btn btn-warning btn-xs']) !!}
                        {!!Form::submit('Eliminar',['class' => 'btn btn-danger btn-xs'])!!}
                    {!!Form::close()!!}

                    {{-- {{ Form::open(['route'=>['classrooms.destroy', $classroom->id, 'method'=>'DELETE'], 'class'=>'form-horizontal form-label-left"']) }}
                    {!! link_to_route('classrooms.edit', $title = 'Ver', $parameters = $classroom->id, $attributes = ['class' => 'btn btn-info btn-xs']) !!}
                    {!! link_to_route('classrooms.edit', $title = 'Editar', $parameters = $classroom->id, $attributes = ['class' => 'btn btn-primary btn-xs']) !!}
                    <a data-target="#delete-modal" data-toggle="modal" href="#">
                        <span class="btn btn-danger btn-xs">
                            Eliminar
                        </span>
                    </a>
                    {{ Form::close() }} --}}
                    {{--@include('modals.delete_modal', ['r' => 'classrooms.destroy', 'id' => $classroom->id])--}}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
   
</div>
<div class="text-right">
    {{ $classrooms->render() }}
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
@include('forms.alerts')

