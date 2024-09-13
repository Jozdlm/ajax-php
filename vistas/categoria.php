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
                <h1 class="box-title">Categoría <button class="btn btn-success" id="btnagregar"
                    onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button> <a
                    href="../reportes/rptcategorias.php" target="_blank"><button class="btn btn-info"><i
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
                    <th>Descripción</th>
                    <th>Estado</th>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                    <th>Opciones</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                  </tfoot>
                </table>
              </div>
              <div class="panel-body" style="height: 400px;" id="formularioregistros">
                <form name="formulario" id="formulario" method="POST">
                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label>Nombre:</label>
                    <input type="hidden" name="idcategoria" id="idcategoria">
                    <input type="text" class="form-control" name="nombre" id="nombre" maxlength="50" placeholder="Nombre"
                      required>
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label>Descripción:</label>
                    <input type="text" class="form-control" name="descripcion" id="descripcion" maxlength="256"
                      placeholder="Descripción">
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
  <script>
    var tabla;

    //Función que se ejecuta al inicio
    function init() {
      mostrarform(false);
      listar();

      $("#formulario").on("submit", function (e) {
        guardaryeditar(e);
      });
      $('#mAlmacen').addClass("treeview active");
      $('#lCategorias').addClass("active");
    }

    //Función limpiar
    function limpiar() {
      $("#idcategoria").val("");
      $("#nombre").val("");
      $("#descripcion").val("");
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
            url: '../ajax/categoria.php?op=listar',
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
        url: "../ajax/categoria.php?op=guardaryeditar",
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

    function mostrar(idcategoria) {
      $.post("../ajax/categoria.php?op=mostrar", { idcategoria: idcategoria }, function (data, status) {
        data = JSON.parse(data);
        mostrarform(true);

        $("#nombre").val(data.nombre);
        $("#descripcion").val(data.descripcion);
        $("#idcategoria").val(data.idcategoria);

      })
    }

    //Función para desactivar registros
    function desactivar(idcategoria) {
      bootbox.confirm("¿Está Seguro de desactivar la Categoría?", function (result) {
        if (result) {
          $.post("../ajax/categoria.php?op=desactivar", { idcategoria: idcategoria }, function (e) {
            bootbox.alert(e);
            tabla.ajax.reload();
          });
        }
      })
    }

    //Función para activar registros
    function activar(idcategoria) {
      bootbox.confirm("¿Está Seguro de activar la Categoría?", function (result) {
        if (result) {
          $.post("../ajax/categoria.php?op=activar", { idcategoria: idcategoria }, function (e) {
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