<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"])) {
  header("Location: vistas/login.html");
} else {
  require $_SERVER['DOCUMENT_ROOT'] . '/vistas/header.php';
  if ($_SESSION['almacen'] == 1) {
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
                <h1 class="box-title">Artículo</h1>
                <div class="box-tools pull-right">
                  <a class="btn btn-success" id="btnagregar" href="app/products/add-product.php"><i
                      class="fa fa-plus-circle"></i> Agregar</a> <a href="/reportes/rptarticulos.php"
                    target="_blank"><button class="btn btn-info"><i class="fa fa-clipboard"></i> Reporte</button></a>
                </div>
              </div>
              <!-- /.box-header -->
              <!-- centro -->
              <div class="panel-body table-responsive" id="listadoregistros">
                <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                  <thead>
                    <th>Opciones</th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Código</th>
                    <th>Stock</th>
                    <th>Imagen</th>
                    <th>Estado</th>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                    <th>Opciones</th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Código</th>
                    <th>Stock</th>
                    <th>Imagen</th>
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
    require $_SERVER['DOCUMENT_ROOT'] . '/vistas/noacceso.php';
  }
  require $_SERVER['DOCUMENT_ROOT'] . '/vistas/footer.php';
  ?>
  <script type="text/javascript" src="/public/js/JsBarcode.all.min.js"></script>
  <script type="text/javascript" src="/public/js/jquery.PrintArea.js"></script>
  <script>
    var tabla;

    //Función que se ejecuta al inicio
    function init() {
      listar();
      $('#mAlmacen').addClass("treeview active");
      $('#lArticulos').addClass("active");
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
            url: '/ajax/articulo.php?op=listar',
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

    //Función para desactivar registros
    function desactivar(idarticulo) {
      bootbox.confirm("¿Está Seguro de desactivar el artículo?", function (result) {
        if (result) {
          $.post("/ajax/articulo.php?op=desactivar", { idarticulo: idarticulo }, function (e) {
            bootbox.alert(e);
            tabla.ajax.reload();
          });
        }
      })
    }

    //Función para activar registros
    function activar(idarticulo) {
      bootbox.confirm("¿Está Seguro de activar el Artículo?", function (result) {
        if (result) {
          $.post("/ajax/articulo.php?op=activar", { idarticulo: idarticulo }, function (e) {
            bootbox.alert(e);
            tabla.ajax.reload();
          });
        }
      })
    }

    init();
  </script>
  <?php
}
ob_end_flush();
?>