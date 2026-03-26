<div class="modal fade" id="modalInhabilitarSeguimiento" tabindex="-1" aria-labelledby="modalInhabilitarSeguimientoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="modalInhabilitarSeguimientoLabel">
                    <i class="fas fa-trash-alt me-2"></i> Confirmar Inhabilitación
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="<?php echo getUrl("ActividadesSeguimiento", "Actividades", "postDelete"); ?>" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="id_seguimiento_inhabilitar" id="id_seguimiento_inhabilitar">
                    
                    <p class="lead text-center">
                        ¿Está seguro que desea inhabilitar el Seguimiento N° <strong id="seguimientoIdText" class="text-danger"></strong>?
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Sí, Inhabilitar</button>
                </div>
            </form>
        </div>
    </div>
</div>