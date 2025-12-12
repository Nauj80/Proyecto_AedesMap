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
                .then(response => response.text())
                .then(data => {
                    contenido.innerHTML = data;
                })
                .catch(error => {
                    contenido.innerHTML = `
                        <div class="alert alert-danger">
                            Error al cargar los detalles
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
                .then(response => response.text())
                .then(data => {
                    contenido.innerHTML = data;
                })
                .catch(error => {
                    contenido.innerHTML = `
                        <div class="alert alert-danger">
                            Error al cargar los detalles
                        </div>
                    `;
                });
        });
    });
});