@extends('layouts.landingPage')
@section('title', 'Materias')
@section('title-content', 'Materias')
@section('content')


   <div class="text-right">
        {!!link_to('subjects/create', $title = '', $attributes = ['class' => 'fa fa-plus fa-3x pointer blackColor'], $secure = null)!!}
    </div>
</div>

@if(Session::has('message'))
<div class="alert alert-success" id="Success">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    {{ session::get('message') }}
</div>
@endif 

@if (count($subject) > 0)

      <div class="table-responsive">
        <table class="table table-striped jambo_table bulk_action">
          <thead>
            <tr class="headings">
              <th>#</th>
              <th class="column-title">Codigo de la Materia</th>
              <th class="column-title">Materia</th>
              <th class="column-title">Creditos</th>
                     
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
            @foreach($subject as $subjects)
            <?php $contador++?>
            <tr class="even pointer">
                <td>
                    {{ $contador }}
                </td>
                <td>
                    {{ $subjects->code_subject }}
                </td>
                <td>
                    {{ $subjects->subject }}
                </td>

                <td>
                    {{ $subjects->credits }}
                </td>
                
                <td class="last">    
                    
                    {!!Form::open(['route'=> ['subjects.destroy', $subjects->id], 'method' => 'DELETE'])!!}
                             {!! link_to_route('subjects.edit', $title = 'Editar', $parameters = $subjects->id, $attributes = ['class' => 'btn btn-warning btn-xs']) !!}
                        {!!Form::submit('Eliminar',['class' => 'btn btn-danger btn-xs'])!!}

                    {!!Form::close()!!}
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
    {{ $subject->render() }}
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
@section('script')
@include('forms.alerts')

@endsection