@extends('layouts.landingPage')
@section('title', 'Profesores')
@section('title-content', 'Profesores')
@section('content')

  @if(Session::has('message'))
    <div class="alert alert-success">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      {{ session::get('message') }}
    </div>
  @endif
  @if(Session::has('message2'))
    <div class="alert alert-danger">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      {{ session::get('message2') }}
    </div>
  @endif
  
    <div class="col-lg-12 text-right ">
      {!!link_to('teachers/create', $title = '', $attributes = ['class' => 'fa fa-plus fa-3x pointer blackColor'], $secure = null)!!}
    </div>
  </div>

@if (count($teachersList) > 0)

      <div class="table-responsive">
        <table class="dataTables_wrapper form-inline dt-bootstrap no-footer jambo_table bulk_action display "  id='table_id'>
          <thead>
            <tr class="headings">
              <th>#</th>
              <th class="column-title">Nombres </th>
              <th class="column-title">Apellidos </th>
              <th class="column-title">Estado</th>
              <th class="column-title">identificacion</th>
              <th class="column-title">telefono</th>
              
              <th class="column-title">genero</th>
              <th class="column-title">Direccion</th>
              <th class="column-title no-link last remove"><span class="nobr">Acción</span>
              </th>
              <th class="bulk-actions" colspan="7">
                <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
              </th>
            </tr>
          </thead>

          <tbody>
            <?php $contador = 0;?>
            @foreach ($teachersList as $teachers)
              <?php $contador++?>
              <tr class="even pointer">
                <td class="a-center ">{{$contador}}</td>
                <td class=" ">{{$teachers->names}}</td>
                <td class=" ">{{$teachers->last_name}}</td>
               <!--condicion para que si el estado del profesor es 1 imprima activo-->
                @if ($teachers->status == 1)
                <td class=" ">Activo</i></td>
               <!--condicion para que si el estado del profesor es 0 imprima inactivo-->
                @else
                <td class=" ">Inactivo</i></td>
                @endif
                <td class=" ">{{$teachers->identity_card}}</td>
                <td class=" ">@if($teachers->personal_phone != "") {{$teachers->personal_phone}} @else N/A @endif</td>
                
                <td class=" ">{{$teachers->gender}}</td>
                <td class=" ">@if($teachers->address != "") {{$teachers->address}} @else N/A @endif</td>
                <td class="last remove">

                 
                    
                    {!!Form::open(['route'=> ['teachers.destroy', $teachers->id], 'method' => 'DELETE'])!!}
                     
                    {!! link_to_route('teachers.edit', $title = 'Editar', $parameters = $teachers->id, $attributes = ['class' => 'btn btn-warning btn-xs']) !!}
                     
                     {!! link_to_route('teachers.show', $title = 'Materias', $parameters = $teachers->id, $attributes = ['class' => 'btn btn-success btn-xs']) !!}
                       
                        {!!Form::submit('Eliminar',['class' => 'btn btn-danger btn-xs'])!!}
                    {!!Form::close()!!}

                  

                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <nav aria-label="Page navigation example">
        <ul class="pagination">
        {!! $teachersList->links() !!}
        </ul>
      </nav>

      <button class="btn btn-default" onclick="window.print();"><i class="fa fa-print"></i> Print</button>
        {{-- modal --}}
        @include('modals.teacher_deletemodal', ['ruta' => 'teachers.destroy', 'id' => $teachers->id])



@else
@include('forms.teacherSearch',['url'=>'teachers','link'=>'teachers'])
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
    document.getElementById("table_id").style.overflow = "scroll";
    window.onload = function () { 
    document.body.style.overflowY = "hidden";
    document.body.style.overflow = "hidden";
    
        setTimeout(function() {
            $('#Warning').fadeToggle();
            }, 5000); // <-- time in milliseconds


    $(document).ready(function() {
    $('#table_id').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            {
                text: 'PDF',
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [ 1, 2, 3,4,5,6,7]
                },
                customize: function ( doc ) {
                    doc.content.splice( 1, 0, {
                        margin: [ 0, 0, 0, 12 ],
                        alignment: 'center',
                        image: 'data:image/jpeg;base64,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'
                    } );
                }
            }
        ]
    } );
} );
}
  </script>
@endsection