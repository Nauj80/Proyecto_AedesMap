document.addEventListener('DOMContentLoaded', function() {
    // Función auxiliar para cargar contenido vía fetch
    function cargarContenido(url, elementoContenido) {
        // Mostrar spinner
        elementoContenido.innerHTML = `
            <div class="text-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Cargando...</span>
                </div>
            </div>
        `;
        
        // Cargar contenido via fetch
        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta: ' + response.status);
                }
                return response.text();
            })
            .then(data => {
                elementoContenido.innerHTML = data;
            })
            .catch(error => {
                elementoContenido.innerHTML = `
                    <div class="alert alert-danger">
                        Error al cargar: ${error.message}
                    </div>
                `;
                console.error('Error en fetch:', error); // Para debug
            });
    }

    // Para el modal de Ver Detalle: Cargar al abrir el modal
    const modalVerDetalle = document.getElementById('modalVerDetalle');
    if (modalVerDetalle) {
        modalVerDetalle.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget; // Botón que activó el modal
            const url = button.getAttribute('data-url');
            const contenido = document.getElementById('contenidoDetalle'); // Asegúrate de que este ID exista en el modal
            if (url && contenido) {
                cargarContenido(url, contenido);
            }
        });
    }

    // Para el modal de Editar: Cargar al abrir el modal
    const modalEditar = document.getElementById('modalEditarZoocriadero');
    if (modalEditar) {
        modalEditar.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget; // Botón que activó el modal
            const url = button.getAttribute('data-url');
            const contenido = document.getElementById('contenidoEditar'); // Asegúrate de que este ID exista en el modal
            if (url && contenido) {
                cargarContenido(url, contenido);
            }
        });
    }

    // Limpiar contenido al cerrar cualquier modal (para evitar datos residuales)
    [modalVerDetalle, modalEditar].forEach(modal => {
        if (modal) {
            modal.addEventListener('hidden.bs.modal', function() {
                const contenido = modal.querySelector('#contenidoDetalle') || modal.querySelector('#contenidoEditar');
                if (contenido) {
                    contenido.innerHTML = ''; // Vaciar para la próxima apertura
                }
            });
        }
    });

    // Tu código original para click (opcional, pero ahora redundante con show.bs.modal)
    // Lo dejo comentado; puedes removerlo si usas solo show.bs.modal
    /*
    const botonesDetalle = document.querySelectorAll('.btn-ver-detalle');
    const botonesEditar = document.querySelectorAll('.btn-Editar');
    
    botonesDetalle.forEach(boton => {
        boton.addEventListener('click', function() {
            const url = this.getAttribute('data-url');
            const contenido = document.getElementById('contenidoDetalle');
            cargarContenido(url, contenido);
        });
    });

    botonesEditar.forEach(boton => {
        boton.addEventListener('click', function() {
            const url = this.getAttribute('data-url');
            const contenido = document.getElementById('contenidoEditar');
            cargarContenido(url, contenido);
        });
    });
    */
    // Nuevo: Manejar el envío del formulario de edición vía AJAX
    document.addEventListener('submit', function(event) {
        if (event.target && event.target.id === 'formEditarZoocriadero') { // Asume que el formulario tiene id="formEditarZoocriadero"
            event.preventDefault(); // Evitar envío normal
            
            const formData = new FormData(event.target);
            const url = 'ajax.php?modulo=Zoocriadero&controlador=Zoocriadero&funcion=actualizar'; // URL del controlador
            
            fetch(url, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const mensajeDiv = document.getElementById('mensajeActualizacion');
                if (data.success) {
                    // Éxito: mostrar mensaje verde
                    mensajeDiv.innerHTML = `<div class="alert alert-success alert-dismissible fade show" role="alert">${data.message}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>`;
                    mensajeDiv.style.display = 'block';
                    
                    // Cerrar modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('modalEditarZoocriadero'));
                    modal.hide();
                    
                    // Recargar solo la tabla (tbody) para reflejar cambios sin recargar la página
                    recargarTabla();
                    
                    // Opcional: Ocultar el mensaje automáticamente después de 5 segundos
                    setTimeout(() => {
                        mensajeDiv.style.display = 'none';
                    }, 5000);
                } else {
                    // Error: mostrar mensaje rojo en el modal
                    const modalBody = document.querySelector('#modalEditarZoocriadero .modal-body');
                    modalBody.innerHTML += `<div class="alert alert-danger mt-3">${data.message}</div>`;
                }
            })
            .catch(error => {
                console.error('Error en AJAX:', error);
                const modalBody = document.querySelector('#modalEditarZoocriadero .modal-body');
                modalBody.innerHTML += `<div class="alert alert-danger mt-3">Error inesperado al actualizar.</div>`;
            });
        }
    });

    // Función para recargar la tabla vía AJAX
    function recargarTabla() {
        const urlListar = 'ajax.php?modulo=Zoocriadero&controlador=Zoocriadero&funcion=listar'; // URL para obtener el HTML completo de la tabla
        
        fetch(urlListar)
            .then(response => response.text())
            .then(html => {
                // Extraer solo el tbody del HTML recibido (para no reemplazar toda la página)
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const nuevoTbody = doc.querySelector('tbody');
                
                if (nuevoTbody) {
                    // Reemplazar el tbody actual con el nuevo
                    document.querySelector('tbody').innerHTML = nuevoTbody.innerHTML;
                } else {
                    console.error('No se pudo encontrar el tbody en la respuesta.');
                }
            })
            .catch(error => {
                console.error('Error al recargar la tabla:', error);
            });
    }
});


// Función para mostrar loading al enviar formulario
function showLoading() {
    document.body.innerHTML = '<div style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 9999;"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Cargando...</span></div></div>';
}

// Función para inhabilitar/habilitar via AJAX
function inhabilitar(id, estado) {
    fetch('ajax.php?modulo=Zoocriadero&controlador=Zoocriadero&funcion=inhabilitar&id_zoocriadero=' + id + '&estado=' + estado)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Mostrar mensaje temporal
                const alertHtml = '<div class="alert alert-success alert-dismissible fade show" style="position: fixed; top: 100px; right: 100px; z-index: 9999;">' + data.message + '<button type="button" class="btn-close ms-6" data-bs-dismiss="alert"></button></div>';
                document.body.insertAdjacentHTML('afterbegin', alertHtml);
                setTimeout(() => {
                    const alert = document.querySelector('.alert');
                    if (alert) alert.remove();
                }, 2000);

                // Recargar la tabla con el filtro actual
                const buscar = document.getElementById('filtro').value;
                fetch('ajax.php?modulo=Zoocriadero&controlador=Zoocriadero&funcion=filtro&buscar=' + encodeURIComponent(buscar))
                    .then(response => response.text())
                    .then(html => {
                        document.querySelector('tbody').innerHTML = html;
                    });
            } else {
                // Mostrar error
                const alertHtml = '<div class="alert alert-danger alert-dismissible fade show" style="position: fixed; top: 100px; right: 100px; z-index: 9999;">' + data.message + '<button type="button" class="btn-close ms-6" data-bs-dismiss="alert"></button></div>';
                document.body.insertAdjacentHTML('afterbegin', alertHtml);
                setTimeout(() => {
                    const alert = document.querySelector('.alert');
                    if (alert) alert.remove();
                }, 2000);
            }
        })
        .catch(error => {
            const alertHtml = '<div class="alert alert-danger alert-dismissible fade show" style="position: fixed; top: 100px; right: 100px; z-index: 9999;">Error: ' + error.message + '<button type="button" class="btn-close ms-6" data-bs-dismiss="alert"></button></div>';
            document.body.insertAdjacentHTML('afterbegin', alertHtml);
            setTimeout(() => {
                const alert = document.querySelector('.alert');
                if (alert) alert.remove();
            }, 2000);
        });
}