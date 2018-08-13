@extends('layouts.landingPage')
@section('title', 'Historico')
@section('title-content', 'Historico')
@section('content')
@if(Session::has('message'))
<div class="alert alert-danger" id='Danger'>
    {{ session::get('message') }}
</div>
@endif

@if (count($log) > 0)
<div class="table-responsive">
    <table class="table table-striped jambo_table bulk_action" id='table_id'>
        <thead>
            <tr class="headings">
                <th>
                    #
                </th>
                <th class="column-title">
                    Tipo de actividad
                </th>
                <th class="column-title">
                    Descripcion
                </th>
                <th class="column-title">
                    Fecha
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
            <?php $contador = 0; ?>
            @foreach ($log as $logs)
            
            <?php $contador++ ?>
            <tr class="even pointer">
                <td class="a-center ">
                    {{$contador}}
                </td>
                <td class=" ">
                    {{$logs->log_name}}
                </td>
                <td class=" ">
                    {{$logs->description}}
                </td>
                 <td class=" ">
                    {{$logs->created_at}}
                </td>
                
                 
                @endforeach
            </tr>
        </tbody>
    </table>
    </div>

    {{--<nav aria-label="Page navigation example">
        <ul class="pagination">
            {!! $studentsList->links() !!}
        </ul>--}}
    {{--</nav>--}}
    
    <button class="btn btn-default" onclick="window.print();"><i class="fa fa-print"></i> Print</button>
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
<script>

$(document).ready(function() {
    $('#table_id').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'pdfHtml5',
                message: 'PDF created by PDFMake with Buttons for DataTables.'
            }
        ]
    } );
} );

</script>
@endsection