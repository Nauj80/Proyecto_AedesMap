<div class="modal fade" id="modalInhabilitarZoo" tabindex="-1" aria-labelledby="modalInhabilitarZooLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="modalInhabilitarZooLabel">
                    <i class="fas fa-trash-alt me-2"></i> Confirmar Inhabilitación de Zoocriadero
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="<?php echo getUrl("Zoocriadero", "Zoocriadero", "inhabilitar"); ?>" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="id_zoocriadero" id="id_zoocriadero">
                    <input type="hidden" name="estado" id="estado_zoocriadero">
                    
                    <p class="lead text-center">
                        ¿Está seguro que desea inhabilitar el Seguimiento N° <strong id="zoocriaderoIdText" class="text-danger"></strong>?
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