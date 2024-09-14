<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"])) {
  header("Location: vistas/login.html");
} else {
  require $_SERVER['DOCUMENT_ROOT'] . '/app/header.php';
  if ($_SESSION['acceso'] == 1) {
    ?>
    <!--Contenido-->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="box">
              <div class="box-header with-border">
                <h1 class="box-title">Permiso</h1>
              </div>
              <!-- /.box-header -->
              <!-- centro -->
              <div class="panel-body table-responsive" id="listadoregistros">
                <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                  <thead>
                    <th>Nombre</th>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                    <th>Nombre</th>
                  </tfoot>
                </table>
              </div>

              <!--Fin centro -->
            </div><!-- /.box -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
    <!--Fin-Contenido-->
    <?php
  } else {
    require $_SERVER['DOCUMENT_ROOT'] . '/app/noacceso.php';
  }
  require $_SERVER['DOCUMENT_ROOT'] . '/app/footer.php';
  ?>
  <script>
    var tabla;

    //Función que se ejecuta al inicio
    function init() {
      listar();
      $('#mAcceso').addClass("treeview active");
      $('#lPermisos').addClass("active");
    }

    //Función Listar
    function listar() {
      tabla = $('#tbllistado').dataTable(
        {
          "lengthMenu": [5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
          "aProcessing": true,//Activamos el procesamiento del datatables
          "aServerSide": true,//Paginación y filtrado realizados por el servidor
          dom: '<Bl<f>rtip>',//Definimos los elementos del control de tabla
          buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdf'
          ],
          "ajax":
          {
            url: '/api/permiso.php?op=listar',
            type: "get",
            dataType: "json",
            error: function (e) {
              console.log(e.responseText);
            }
          },
          "language": {
            "lengthMenu": "Mostrar : _MENU_ registros",
            "buttons": {
              "copyTitle": "Tabla Copiada",
              "copySuccess": {
                _: '%d líneas copiadas',
                1: '1 línea copiada'
              }
            }
          },
          "bDestroy": true,
          "iDisplayLength": 10,//Paginación
          "order": [[0, "desc"]]//Ordenar (columna,orden)
        }).DataTable();
    }

    init();
  </script>
  <?php
}
ob_end_flush();
?>