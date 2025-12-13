    $(document).ready(function() {

        $(document).on("keyup","#filtro",function(){
            
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
                success: function(data){
                    $("tbody").html(data);
                }
            })

        });
    });