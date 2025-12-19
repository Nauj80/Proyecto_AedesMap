<!-- Modal detalle zoocriadero -->
<div class="modal fade" id="detalleZoocriaderoModal" tabindex="-1" aria-labelledby="detalleZoocriaderoLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="detalleZoocriaderoLabel">
                    <i class="fas fa-info-circle"></i> Detalle del Zoocriadero
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-sm-6"><strong>Nombre:</strong> <span id="nombreZoocriadero"></span></div>
                    <div class="col-sm-6"><strong>Estado:</strong> <span id="estadoZoocriadero"></span></div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-6"><strong>Dirección:</strong> <span id="direccionZoocriadero"></span></div>
                    <div class="col-sm-6"><strong>Barrio:</strong> <span id="barrioZoocriadero"></span></div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-6"><strong>Comuna:</strong> <span id="comunaZoocriadero"></span></div>
                    <div class="col-sm-6"><strong>Teléfono:</strong> <span id="telefonoZoocriadero"></span></div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-12"><strong>Correo:</strong> <span id="correoZoocriadero"></span></div>
                </div>
            </div>
            <div class="text-center m-2">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Función para cargar los detalles del zoocriadero
    function cargarDetalleZoocriadero(x, y) {
        fetch('consulta_zoocriadero.php?x=' + x + '&y=' + y)
            .then(response => response.json())
            .then(data => {
                if (data.encontrado) {
                    document.getElementById('nombreZoocriadero').textContent = data.nombre || 'N/A';
                    document.getElementById('estadoZoocriadero').textContent = data.estado || 'N/A';
                    document.getElementById('direccionZoocriadero').textContent = data.direccion || 'N/A';
                    document.getElementById('barrioZoocriadero').textContent = data.barrio || 'N/A';
                    document.getElementById('comunaZoocriadero').textContent = data.comuna || 'N/A';
                    document.getElementById('telefonoZoocriadero').textContent = data.telefono || 'N/A';
                    document.getElementById('correoZoocriadero').textContent = data.correo || 'N/A';

                    // Mostrar el modal
                    var modal = new bootstrap.Modal(document.getElementById('detalleZoocriaderoModal'));
                    modal.show();
                } else {
                    alert('No se encontró ningún zoocriadero en esas coordenadas');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al consultar los datos');
            });
    }
</script>