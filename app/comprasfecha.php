<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"])) {
  header("Location: /login.php");
} else {
  require $_SERVER['DOCUMENT_ROOT'] . '/app/header.php';

  if ($_SESSION['consultac'] == 1) {
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
                <h1 class="box-title">Consulta de Compras por fecha </h1>
                <div class="box-tools pull-right">
                </div>
              </div>
              <!-- /.box-header -->
              <!-- centro -->
              <div class="panel-body table-responsive" id="listadoregistros">
                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <label>Fecha Inicio</label>
                  <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio"
                    value="<?php echo date("Y-m-d"); ?>">
                </div>
                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <label>Fecha Fin</label>
                  <input type="date" class="form-control" name="fecha_fin" id="fecha_fin"
                    value="<?php echo date("Y-m-d"); ?>">
                </div>
                <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                  <thead>
                    <th>Fecha</th>
                    <th>Usuario</th>
                    <th>Proveedor</th>
                    <th>Comprobante</th>
                    <th>Número</th>
                    <th>Total Compra</th>
                    <th>Impuesto</th>
                    <th>Estado</th>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                    <th>Fecha</th>
                    <th>Usuario</th>
                    <th>Proveedor</th>
                    <th>Comprobante</th>
                    <th>Número</th>
                    <th>Total Compra</th>
                    <th>Impuesto</th>
                    <th>Estado</th>
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
      $("#fecha_inicio").change(listar);
      $("#fecha_fin").change(listar);
      $('#mConsultas').addClass("treeview active");
      $('#lConsulasC').addClass("active");
    }


    //Función Listar
    function listar() {
      var fecha_inicio = $("#fecha_inicio").val();
      var fecha_fin = $("#fecha_fin").val();

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
            url: '/api/consultas.php?op=comprasfecha',
            data: { fecha_inicio: fecha_inicio, fecha_fin: fecha_fin },
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
          "iDisplayLength": 5,//Paginación
          "order": [[0, "desc"]]//Ordenar (columna,orden)
        }).DataTable();
    }
    init();
  </script>
  <?php
}
ob_end_flush();
?>