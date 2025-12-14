$(document).ready(function() {
    $(document).on("keyup", "#filtro", function() {
        let data = $(this).val();
        let url = $(this).data("url");
        // convertir a mayusculas la primera letra de cada palabra
        data = data.trim();
        data = data.replace(/\b\w/g, function(l) { return l.toUpperCase() });
        

        $.ajax({
            url: url,
            type: "GET",
            data: {
                buscar: data
            },
            success: function(data) {
                if (data.includes('<tr>')) {
                    // Hay resultados: inserta en el tbody y muestra la tabla
                    $("tbody").html(data);
                    $('.table-responsive').show();
                    $('#mensajeActualizacion').hide();  // Oculta cualquier mensaje anterior
                } else {
                    // No hay resultados: oculta la tabla y muestra el mensaje en el div dedicado
                    $('.table-responsive').hide();
                    $('#mensajeActualizacion').html(data).show();  // Muestra la alerta en #mensajeActualizacion
                }
            }
        });
    });
});
