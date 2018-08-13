<div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Confirmación para eliminar</h4>
            </div>

            <div class="modal-body">
                <p>Si Elimina este recurso sera irreversible.</p>
                <p>Desea proceder?</p>
                <p class="debug-url"></p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                {!! Form::open(['route' => [$ruta, $id],'method'=>'DELETE']) !!}
                  {!!Form::submit('Si, Quiero eliminar', ['class' => 'btn btn-danger btn-ok'])!!}
                {!!Form::close()!!}
            </div>
        </div>
    </div>
</div>