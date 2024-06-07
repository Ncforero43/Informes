//=====================Procesos para mostrar y editar informacion del usuario=======================

//Mostrar el formulario donde se insertaran los datos del usuario
function GenerarInforme()
{
    let Insert =
    {
        url:'Controller/Controller.php',
        method:'POST',
        data: 
            {
            accion: 'Formulario',
            }
    }
    $.ajax(Insert)
    .done((resp) => {
        $('.modal-title').html('Generar informe')
        $('.modal-body').html(resp);
    }).fail((error)=>    {   
        $('.modal-body').html(error);
    })
    $('#Generar').modal('show');
}

//para insertar los datos del usuario enviados desde el formulario
function MakeConsult(Usu_ID) {
    var accion = 'Element'; 
        alert(Usu_ID);
    $.ajax({
        url: 'Controller/Controller.php',
        type: 'POST',
        data: { Usu_ID: Usu_ID, accion: accion },
    })
    .done(function(response) {


        $('#informe').html(response);

    })
    .fail(function(error) {
        console.error('Error al cargar elementos del ambiente:', error);
    });
}



