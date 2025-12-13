document.addEventListener('DOMContentLoaded', function() {
    const botonesDetalle = document.querySelectorAll('.btn-ver-detalle');
    const botonesEditar = document.querySelectorAll('.btn-Editar');
    
    botonesDetalle.forEach(boton => {

        boton.addEventListener('click', function() {
            const url = this.getAttribute('data-url');
            const contenido = document.getElementById('contenidoDetalle');
            // Mostrar spinner mientras carga
            contenido.innerHTML = `
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                </div>
            `;
            
            // Cargar contenido via AJAX
            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error en la respuesta: ' + response.status);
                    }
                    return response.text();
                })
                .then(data => {
                    contenido.innerHTML = data;
                })
                .catch(error => {
                    contenido.innerHTML = `
                        <div class="alert alert-danger">
                            Error al cargar los detalles: ${error.message}
                        </div>
                    `;
                });
        });
    });

    botonesEditar.forEach(boton => {
        boton.addEventListener('click', function() {
            const url = this.getAttribute('data-url');
            const contenido = document.getElementById('contenidoEditar');
            // Mostrar spinner mientras carga
            contenido.innerHTML = `
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                </div>
            `;
            
            // Cargar contenido via AJAX
            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error en la respuesta: ' + response.status);
                    }
                    return response.text();
                })
                .then(data => {
                    contenido.innerHTML = data;
                })
                .catch(error => {
                    contenido.innerHTML = `
                        <div class="alert alert-danger">
                            Error al cargar los detalles: ${error.message}
                        </div>
                    `;
                });
        });
    });
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