document.addEventListener('DOMContentLoaded', function() {
    
    if (typeof bootstrap === 'undefined') {
        console.error("ADVERTENCIA CRÍTICA: Bootstrap 5 JS no está cargado. Asegure que bootstrap.bundle.min.js se cargue antes de este script.");
        return; 
    }
  
    const modalEditarElement = document.getElementById('modalEditarActividad');
    let modalEditar = modalEditarElement ? new bootstrap.Modal(modalEditarElement) : null;

    const modalInhabilitarElement = document.getElementById('modalInhabilitarActividad'); 

    const botonesEditar = document.querySelectorAll('.btn-editar-actividad');

    botonesEditar.forEach(boton => {
        boton.addEventListener('click', function() {
        
            const contenido = document.getElementById('contenidoEditarActividad'); 
            
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
            const idActividad = button.getAttribute('data-id'); 
            
            // Los IDs de los campos deben coincidir con tu HTML de la modal estática
            const modalInput = this.querySelector('#id_actividad_inhabilitar');
            const modalText = this.querySelector('#actividadIdText');

            if (modalInput) {
                modalInput.value = idActividad;
            }
            if (modalText) {
                modalText.textContent = idActividad;
            } else {
                console.warn("Advertencia: No se encontró el elemento #actividadIdText para mostrar el ID.");
            }
        });
    }
});