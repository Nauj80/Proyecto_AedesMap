function precargarCantidadTanque(tanqueSelectElement) {
    let id_tanque = tanqueSelectElement.val();
    let url_base = tanqueSelectElement.data("url"); 
    
    if (!id_tanque || id_tanque === "") {
        $("#cantidad_inicial_tanque").val(0);
        return;
    }

    $.ajax({
        url: url_base,
        type: "GET",
        data: { 
            id_tanque: id_tanque
        },
        dataType: 'json',
        success: function (response) {
            $("#cantidad_inicial_tanque").val(response.cantidad);
            console.log('Población inicial precargada: ' + response.cantidad);
        },
    });
}

$(document).ready(function () {

    $(document).on("keyup", "#filtro", function () {

        let data = $(this).val();
        let url = $(this).data("url");

        //convertir a mayusculas la primera letra de cada palabra
        data = data.replace(/\b\w/g, function(l){ return l.toUpperCase() });

        $.ajax({
            url: url,
            type: "GET",
            data: {
                buscar: data
            },
            success: function (data) {
                $("tbody").html(data);
            }
        })

    });
    
    $(document).on("change", "#id_zoocriadero", function () {

        let data = $(this).val();
        let url = $(this).data("url");

        $.ajax({
            url,
            type: "GET",
            data: {
                id_zoocriadero: data
            },
            success: function (data) {
                $("#id_tanque").html(data);
                $("#id_tanque").trigger('change');
            }
        })

    })

    $(document).on("change", "#id_tanque", function () {
        precargarCantidadTanque($(this));
    });
});