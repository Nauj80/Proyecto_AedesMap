document.addEventListener('DOMContentLoaded', function() {
    
    if (typeof bootstrap === 'undefined') {
        console.error("ADVERTENCIA CRÍTICA: Bootstrap 5 JS no está cargado. Asegure que bootstrap.bundle.min.js se cargue antes de este script.");
        return; 
    }

    const modalSeguimientoElement = document.getElementById('modalVerSeguimiento');
    let modalSeguimiento = modalSeguimientoElement ? new bootstrap.Modal(modalSeguimientoElement) : null;
    
    const modalEditarElement = document.getElementById('modalEditarSeguimiento'); // O el ID que uses para la modal de edición
    let modalEditar = modalEditarElement ? new bootstrap.Modal(modalEditarElement) : null;

    const modalInhabilitarElement = document.getElementById('modalInhabilitarSeguimiento'); 
    
    
    const botonesDetalle = document.querySelectorAll('.btn-ver-seguimiento');

    botonesDetalle.forEach(boton => {
        boton.addEventListener('click', function() {
            
            // 1. Declaración local y verificación del contenedor
            const contenido = document.getElementById('contenidoSeguimiento'); 
            
            if (!contenido) {
                 console.error("ERROR: No se encontró el contenedor #contenidoSeguimiento. Verifique el HTML de la modal.");
                 return; 
            }

            const url = this.getAttribute('data-url');
            
            if (modalSeguimiento) {
                modalSeguimiento.show(); 
            } else {
                console.error("ERROR: La instancia de modalSeguimiento es null. La modal no se abrirá.");
                return;
            }
            
            contenido.innerHTML = ` 
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                </div>
            `;
            
            fetch(url)
                .then(response => response.text())
                .then(data => {
                    contenido.innerHTML = data;
                })
                .catch(error => {
                    contenido.innerHTML = `<div class="alert alert-danger">Error: ${error.message}</div>`;
                });
        });
    });

    const botonesEditar = document.querySelectorAll('.btn-editar-seguimiento');

    botonesEditar.forEach(boton => {
        boton.addEventListener('click', function() {
        
            const contenido = document.getElementById('contenidoEditar'); 
            
            if (!contenido) {
                 console.error("ERROR: No se encontró el contenedor #contenidoEditar. Verifique el HTML de la modal de edición.");
                 return;
            }

            const url = this.getAttribute('data-url');
            
            if (modalEditar) { 
                modalEditar.show(); 
            } else {
                 console.error("ERROR: La instancia de modalEditar es null. La modal no se abrirá.");
                 return;
            }
            
            contenido.innerHTML = `
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                </div>
            `;
            
            fetch(url)
                .then(response => response.text())
                .then(data => {
                    contenido.innerHTML = data;
                })
                .catch(error => {
                    contenido.innerHTML = `<div class="alert alert-danger">Error: ${error.message}</div>`;
                });
        });
    });

    if (modalInhabilitarElement) {
        modalInhabilitarElement.addEventListener('show.bs.modal', function (event) {
            
            const button = event.relatedTarget; // Botón que activó el modal
            const idSeguimiento = button.getAttribute('data-id'); 
            
            // Los IDs de los campos deben coincidir con tu HTML de la modal estática
            const modalInput = this.querySelector('#id_seguimiento_inhabilitar');
            const modalText = this.querySelector('#seguimientoIdText');

            if (modalInput) {
                modalInput.value = idSeguimiento;
            }
            if (modalText) {
                modalText.textContent = idSeguimiento;
            } else {
                console.warn("Advertencia: No se encontró el elemento #seguimientoIdText para mostrar el ID.");
            }
        });
    }
});