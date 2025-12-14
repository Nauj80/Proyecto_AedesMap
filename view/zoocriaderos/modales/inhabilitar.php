<!-- Modal Inhabilitar -->
<div class="modal fade" id="modalInhabilitar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle"></i> Confirmar Inhabilitación
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="text-center mb-0">¿Está seguro?</p>
                <input type="hidden" id="id_zoocriadero_inhabilitar">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="btnConfirmarInhabilitar"
                    data-url="<?= getUrl("Zoocriadero", "Zoocriadero", "inhabilitar", false, "ajax"); ?>">
                    <i class="fas fa-ban"></i> Inhabilitar
                </button>
            </div>
        </div>
    </div>
</div>