<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"])) {
  header("Location: login.html");
} else {
  require 'header.php';
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
                <h1 class="box-title">Artículo <button class="btn btn-success" id="btnagregar"
                    onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button> <a
                    href="../reportes/rptarticulos.php" target="_blank"><button class="btn btn-info"><i
                        class="fa fa-clipboard"></i> Reporte</button></a></h1>
                <div class="box-tools pull-right">
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
              <div class="panel-body" id="formularioregistros">
                <form name="formulario" id="formulario" method="POST">
                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label>Nombre(*):</label>
                    <input type="hidden" name="idarticulo" id="idarticulo">
                    <input type="text" class="form-control" name="nombre" id="nombre" maxlength="100" placeholder="Nombre"
                      required>
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label>Categoría(*):</label>
                    <select id="idcategoria" name="idcategoria" class="form-control selectpicker" data-live-search="true"
                      required></select>
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label>Stock(*):</label>
                    <input type="number" class="form-control" name="stock" id="stock" required>
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label>Descripción:</label>
                    <input type="text" class="form-control" name="descripcion" id="descripcion" maxlength="256"
                      placeholder="Descripción">
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label>Imagen:</label>
                    <input type="file" class="form-control" name="imagen" id="imagen"
                      accept="image/x-png,image/gif,image/jpeg">
                    <input type="hidden" name="imagenactual" id="imagenactual">
                    <img src="" width="150px" height="120px" id="imagenmuestra">
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label>Código:</label>
                    <input type="text" class="form-control" name="codigo" id="codigo" placeholder="Código Barras">
                    <button class="btn btn-success" type="button" onclick="generarbarcode()">Generar</button>
                    <button class="btn btn-info" type="button" onclick="imprimir()">Imprimir</button>
                    <div id="print">
                      <svg id="barcode"></svg>
                    </div>
                  </div>
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i>
                      Guardar</button>

                    <button class="btn btn-danger" onclick="cancelarform()" type="button"><i
                        class="fa fa-arrow-circle-left"></i> Cancelar</button>
                  </div>
                </form>
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
    require 'noacceso.php';
  }
  require 'footer.php';
  ?>
  <script type="text/javascript" src="../public/js/JsBarcode.all.min.js"></script>
  <script type="text/javascript" src="../public/js/jquery.PrintArea.js"></script>
  <script>
    var tabla;

    //Función que se ejecuta al inicio
    function init() {
      mostrarform(false);
      listar();

      $("#formulario").on("submit", function (e) {
        guardaryeditar(e);
      })

      //Cargamos los items al select categoria
      $.post("../ajax/articulo.php?op=selectCategoria", function (r) {
        $("#idcategoria").html(r);
        $('#idcategoria').selectpicker('refresh');

      });
      $("#imagenmuestra").hide();
      $('#mAlmacen').addClass("treeview active");
      $('#lArticulos').addClass("active");
    }

    //Función limpiar
    function limpiar() {
      $("#codigo").val("");
      $("#nombre").val("");
      $("#descripcion").val("");
      $("#stock").val("");
      $("#imagenmuestra").attr("src", "");
      $("#imagenactual").val("");
      $("#print").hide();
      $("#idarticulo").val("");
    }

    //Función mostrar formulario
    function mostrarform(flag) {
      limpiar();
      if (flag) {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnGuardar").prop("disabled", false);
        $("#btnagregar").hide();
      }
      else {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
      }
    }

    //Función cancelarform
    function cancelarform() {
      limpiar();
      mostrarform(false);
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
            url: '../ajax/articulo.php?op=listar',
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
    //Función para guardar o editar

    function guardaryeditar(e) {
      e.preventDefault(); //No se activará la acción predeterminada del evento
      $("#btnGuardar").prop("disabled", true);
      var formData = new FormData($("#formulario")[0]);

      $.ajax({
        url: "../ajax/articulo.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function (datos) {
          bootbox.alert(datos);
          mostrarform(false);
          tabla.ajax.reload();
        }

      });
      limpiar();
    }

    function mostrar(idarticulo) {
      $.post("../ajax/articulo.php?op=mostrar", { idarticulo: idarticulo }, function (data, status) {
        data = JSON.parse(data);
        mostrarform(true);

        $("#idcategoria").val(data.idcategoria);
        $('#idcategoria').selectpicker('refresh');
        $("#codigo").val(data.codigo);
        $("#nombre").val(data.nombre);
        $("#stock").val(data.stock);
        $("#descripcion").val(data.descripcion);
        $("#imagenmuestra").show();
        $("#imagenmuestra").attr("src", "../files/articulos/" + data.imagen);
        $("#imagenactual").val(data.imagen);
        $("#idarticulo").val(data.idarticulo);
        generarbarcode();

      })
    }

    //Función para desactivar registros
    function desactivar(idarticulo) {
      bootbox.confirm("¿Está Seguro de desactivar el artículo?", function (result) {
        if (result) {
          $.post("../ajax/articulo.php?op=desactivar", { idarticulo: idarticulo }, function (e) {
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
          $.post("../ajax/articulo.php?op=activar", { idarticulo: idarticulo }, function (e) {
            bootbox.alert(e);
            tabla.ajax.reload();
          });
        }
      })
    }

    //función para generar el código de barras
    function generarbarcode() {
      codigo = $("#codigo").val();
      JsBarcode("#barcode", codigo);
      $("#print").show();
    }

    //Función para imprimir el Código de barras
    function imprimir() {
      $("#print").printArea();
    }

    init();
  </script>
  <?php
}
ob_end_flush();
?>