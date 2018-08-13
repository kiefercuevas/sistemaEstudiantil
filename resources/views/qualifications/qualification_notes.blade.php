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

@if (count($notas) > 0)
<div class="table-responsive">
    <table class="table table-striped jambo_table bulk_action" id="table_id">
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
                    Primer_Parcial
                </th>
                <th class="column-title">
                    Segundo_Parcial
                </th>
                <th class="column-title">
                    Practicas
                </th>
                <th class="column-title">
                    Examen final
                </th>
                <th class="column-title">
                    Total
                </th>
                <th class="column-title">
                    literal
                </th>
                <th class="column-title">
                    condicion
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
            @foreach ($notas as $nota)
            <?php $contador++?>
            <tr class="even pointer">
                <td class="a-center ">
                    {{$contador}}
                </td>
                <td class=" ">
                    {{$nota->names}}
                </td>
                <td class=" ">
                    {{$nota->last_name}}
                </td>
                <td class=" ">
                    {{$nota->identity_card}}
                </td>
                <td class=" ">
                    {{$nota->first_midterm}}
                </td>
                <td class=" ">
                    {{$nota->second_midterm}}
                </td>
                <td class=" ">
                    {{$nota->pratice_score}}
                </td>
                <td class=" ">
                    {{$nota->final_exam}}
                </td>
                <td class=" ">
                    {{$nota->score}}
                </td>
                <td class=" ">
                    {{$nota->literal}}
                </td>
                <td class="last">
                    {{$nota->condition}}
                </td>
                
            </tr>
            @endforeach
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
@section('script')
	<script>


    $(document).ready(function() {
    $('#table_id').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'print',
                customize: function ( win ) {
                    $(win.document.body)
                        .css( 'font-size', '10pt' )
                        .prepend(
                            '<img src="http://datatables.net/media/images/logo-fade.png" style="position:absolute; top:0; left:0;" />'
                        );
 
                    $(win.document.body).find( 'table' )
                        .addClass( 'compact' )
                        .css( 'font-size', 'inherit' );
                }
            }
        ]
    } );
} );
  </script>
@endsection