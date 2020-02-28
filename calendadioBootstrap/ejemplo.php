<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="bootstrap-material-design.min.css">
    <link rel="stylesheet" href="css/fullcalendar.min.css">
    <link rel="stylesheet" href="css/bootstrap-clockpicker.css">
    
</head>
<style>
.fc th{
    padding:10px 0px;
    vertical-align: middle;
    background:#f2f2f2;
}
</style>
<body>

    <div class="container">
        <div class="row">
            <div class="col"></div>
            <div class="col-7"><div id="calendarWeb"></div></div>
            <div class="col"></div>
        </div>
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/moment.min.js"></script>
    <script src="js/fullcalendar.min.js"></script>
    <script src="js/es.js  "></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap-material-design.js"></script>
    <script src="js/bootstrap-clockpicker.js"></script>
    <script>
        $(document).ready(function(){
            $('#calendarWeb').fullCalendar({
            header:{
                left:'today,prev,next',
                center:'title',
                right:'month,basicWeek,basicDay,agendaWeek,agendaDay'
                },
                
                dayClick:function(date, jsEvent, view){
                    $('#btnAgregar').prop("disabled",false);
                   $('#btnModificar').prop("disabled",true);
                   $('#btnBorrar').prop("disabled",true);

                    limpiarForm();
                    $('#txtFecha').val(date.format());
                    $('#ModalEventos').modal();
                },
                events:'eventos.php',

                eventClick:function(calEvent,jsEvent,view){
                    $('#btnAgregar').prop("disabled",true);
                   $('#btnModificar').prop("disabled",false);
                   $('#btnBorrar').prop("disabled",false);

                    $('#tituloEvento').html(calEvent.title);
                    //mostra el los campos de texto la inf
                    $('#txtDescripcion').val(calEvent.descripcion);
                    $('#txtID').val(calEvent.id);
                    $('#txtTitulo').val(calEvent.title);
                    $('#txtColor').val(calEvent.color);
                    
                    FechaHora=calEvent.start._i.split(" ");
                    $('#txtFechaI').val(FechaHora[0]);

                    
                    $('#ModalEventos').modal();
                },
                editable:true,
                eventDrop:function(calEvent){
                    $('#txtID').val(calEvent.id);
                    $('#txtTitulo').val(calEvent.title);
                    $('#txtColor').val(calEvent.color);
                    $('#txtDescripcion').val(calEvent.descripcion);

                    var fechaHora=calEvent.start.format().split("T");
                    $('#txtFecha').val(fechaHora[0]);
                    $('#txtHora').val(fechaHora[1]);

                    RecolectarDatosGUI();
                    EnviarInf('modificar',NuevoEvento, true);
                }
                
            });
        });
    </script>
        <!-- Modal (agregar, modificar, Eliminar)-->
<div class="modal fade" id="ModalEventos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="tituloEvento"></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
             
            <input type="hideen" id="txtID" name="txtID">
            <input type="hideen" id="txtFecha" name="txtFecha">
            
                <div class="col-4 mt-3">
                    <div class="input-group clockpicker" data-autoclose="true">
                        <input required type="text"
                            style="background: white;border-radius: 3px; border: 1px solid #bdc7d8;"
                            class="form-control" id="txtHora" name="txtHora" value="12:00"
                            placeholder="Hora">
                    </div>      
                </div>
                <div class="col-12 mt-3">
                        <input required type="text"
                            style="background: white;border-radius: 3px; border: 1px solid #bdc7d8;"
                            class="form-control" id="txtTitulo" name="txtTitulo"
                            placeholder="Titulo">
                </div>
                <div class="col-12 mt-3">
                        <textarea required type="text"
                            style="background: white;border-radius: 3px; border: 1px solid #bdc7d8;"
                            class="form-control" name="txtDescripcion" id="txtDescripcion"
                            placeholder="Descripcion"></textarea>
                </div>
                <div class="col-12 mt-3">
                        <input required type="color"
                            style="height: 35px; border-radius: 3px; border: 1px solid #bdc7d8;"
                            class="form-control" value="#ff0000" id="txtColor" name="txtColor"
                            placeholder="color">
                        
                </div>
                <div class="col-12 mt-3">
                    <button type="button" id="btnAgregar" class="btn btn-raised btn-success mt-3">gregar</button>
                    <button type="button" id="btnModificar" class="btn btn-raised btn-success mt-3">Modificar</button>
                    <button type="button" id="btnBorrar" class="btn  btn-raised btn-danger mt-3">Borrar</button>
                    <button type="button" class="btn btn-raised btn-default mt-3 " data-dismiss="modal">Cancelar</button>
                </div>
          </div>
      </div>
  </div>
</div>
<script>
    var NuevoEvento;

$('#btnAgregar').click(function(){
    RecolectarDatosGUI();
    EnviarInf('agregar',NuevoEvento);
    
});
$('#btnBorrar').click(function(){
    RecolectarDatosGUI();
    EnviarInf('eliminar',NuevoEvento);
    
});
$('#btnModificar').click(function(){
    RecolectarDatosGUI();
    EnviarInf('modificar',NuevoEvento);
    
});


function RecolectarDatosGUI(){
    NuevoEvento={
        id:$('#txtID').val(),
        title:$('#txtTitulo').val(),
        start:$('#txtFecha').val()+" "+$('#txtHora'),
        end:$('#txtFecha').val()+" "+$('#txtHora'),
        color:$('#txtColor').val(),
        descripcion:$('#txtDescripcion').val(),
        textColor:"#fff"
    };
}
function EnviarInf(accion,objEvento,modal){
    $.ajax({
        type:'POST',
        url:'eventos.php?accion='+accion,
        data:objEvento,
        success:function(msg){
            if(msg){
                $('#calendarWeb').fullCalendar('refetchEvents');
                if(!modal){
                    $('#ModalEventos').modal('toggle');
                }
            }
        },
        error(){
            alert("ay un error");
        }
    });
}
$('.clockpicker').clockpicker();
function limpiarForm(){
        $('#txtID').val('');
        $('#txtTitulo').val('');
        $('#txtColor').val('');
        $('#txtDescripcion').val('');

}
</script>
</body>
</html>