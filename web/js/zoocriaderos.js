// web/js/zoocriaderos.js

$(document).ready(function() {

    // ===== MODAL VER DETALLE =====
    $(document).on("click", "#VerDetalle", function(e) {
        e.preventDefault();
        
        let id = $(this).data("id");
        let url = $(this).data("url");

        $.ajax({
            url: url,
            type: "POST",
            data: { id_zoocriadero: id },
            success: function(data) {
                $("#modalVerDetalle .modal-body").html(data);
                $("#modalVerDetalle").modal("show");
            },
            error: function() {
                alert("Error al cargar los detalles");
            }
        });
    });

    // ===== MODAL EDITAR =====
    $(document).on("click", "#btnEditar", function(e) {
        e.preventDefault();
        
        let id = $(this).data("id");
        let url = $(this).data("url");

        $.ajax({
            url: url,
            type: "POST",
            data: { id_zoocriadero: id },
            success: function(data) {
                $("#modalEditar .modal-body").html(data);
                $("#modalEditar").modal("show");
            },
            error: function() {
                alert("Error al cargar el formulario");
            }
        });
    });

    // Guardar cambios del formulario de editar
    $(document).on("submit", "#formEditar", function(e) {
        e.preventDefault();
        
        let formData = $(this).serialize();
        let url = $(this).attr("action");

        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            success: function(response) {
                $("#modalEditar").modal("hide");
                alert("Zoocriadero actualizado correctamente");
                location.reload();
            },
            error: function() {
                alert("Error al actualizar el zoocriadero");
            }
        });
    });

    // ===== MODAL INHABILITAR =====
    $(document).on("click", "#btnInhabilitar", function(e) {
        e.preventDefault();
        
        let id = $(this).data("id");
        let nombre = $(this).data("nombre");
        
        $("#modalInhabilitar .modal-body p").html(
            `¿Está seguro que desea inhabilitar el zoocriadero <strong>${nombre}</strong>?`
        );
        $("#modalInhabilitar #id_zoocriadero_inhabilitar").val(id);
        $("#modalInhabilitar").modal("show");
    });

    // Confirmar inhabilitar
    $(document).on("click", "#btnConfirmarInhabilitar", function() {
        let id = $("#id_zoocriadero_inhabilitar").val();
        let url = $(this).data("url");

        $.ajax({
            url: url,
            type: "POST",
            data: { id_zoocriadero: id },
            success: function(response) {
                $("#modalInhabilitar").modal("hide");
                alert("Zoocriadero inhabilitado correctamente");
                location.reload();
            },
            error: function() {
                alert("Error al inhabilitar el zoocriadero");
            }
        });
    });

    // Cerrar modales
    $(document).on("click", ".btn-close, [data-bs-dismiss='modal']", function() {
        $(this).closest(".modal").modal("hide");
    });

});