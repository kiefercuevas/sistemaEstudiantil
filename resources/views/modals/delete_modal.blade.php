<div aria-hidden="true" aria-labelledby="myModalLabel" class="modal fade" id="delete-modal" role="dialog" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                    ×
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    Confirmación para eliminar
                </h4>
            </div>
            <div class="modal-body">
                <p>
                    Si Elimina este recurso sera irreversible.
                </p>
                <p>
                    Desea proceder?
                </p>
                <p class="debug-url">
                </p>
            </div>
            <div class="modal-footer">
                {!! Form::open(['route' => [$r, $id],'method'=>'DELETE']) !!}
                <button class="btn btn-default" data-dismiss="modal" type="button">
                    Cancelar
                </button>
                {!!Form::submit('Si, Quiero eliminar', ['class' => 'btn btn-danger btn-ok'])!!}
                {!!Form::close()!!}
            </div>
        </div>
    </div>
</div>