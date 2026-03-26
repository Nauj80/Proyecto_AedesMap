<div class="modal fade" id="modalInhabilitarActividad" tabindex="-1" aria-labelledby="modalInhabilitarActividadLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="modalInhabilitarActividadLabel">
                    <i class="fas fa-trash-alt me-2"></i> Confirmar Inhabilitación
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="<?php echo getUrl("tipoActividades", "tipoActividades", "postDelete"); ?>" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="id_actividad_inhabilitar" id="id_actividad_inhabilitar">
                    
                    <p class="lead text-center">
                        ¿Está seguro que desea inhabilitar la actividad N° <strong id="actividadIdText" class="text-danger"></strong>?
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