@extends('layouts.landingPage')
@section('title', 'Citas')
@section('title-content', 'Citas')
@section('content')



@if(Session::has('message'))
<div class="alert alert-success" id="Success">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    {{ session::get('message') }}
</div>
@endif 

@if (count($language) > 0)

      <div class="table-responsive">
        <table class="table table-striped jambo_table bulk_action" id="table_idlanguaje">
          <thead>
            <tr class="headings">
              <th>#</th>
              <th class="column-title">Lenguaje</th>
              <th class="column-title">Fecha de la cita</th>
              <th class="column-title">Hora</th>
              <th class="column-title">Ubicación</th>

          
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
            @foreach($language as $languages)
            <?php $contador++?>
            <tr class="even pointer">
                <td>
                    {{ $contador }}
                </td>
                <td>
                    {{ $languages->language }}
                </td>

                <td>
                   {!! $languages->date !!}
                </td>
                <td>
                    {{ $languages->time}}
                </td>
                <td>{{$languages->location}}</td>
                <td class="last">    
                   
                  <a href="{{ route('idioma_show_path',['language'=> $languages->id]) }}" class="btn btn-primary btn-xs">Imprimir</a>
                  <a href="{{ route('idioma_edit_path',['language'=> $languages->id]) }}" class="btn btn-primary btn-xs">Editar</a>
              
                </td>
                
            </tr>
            @endforeach
        </tbody>
    </table>    
      </div>
<div class="text-right">
    {{ $language->render() }}
</div>
@else
<div class="text-right ">
        
      <a href="{{ route('idioma_create_path')}}" class="fa fa-plus fa-3x pointer blackColor"> </a>
  </div>
</div>
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