<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"])) {
  header("Location: login.html");
} else {
  require 'header.php';

  if ($_SESSION['ventas'] == 1) {
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
                <h1 class="box-title">Venta <button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i
                      class="fa fa-plus-circle"></i> Agregar</button> <a href="../reportes/rptventas.php"
                    target="_blank"><button class="btn btn-info"><i class="fa fa-clipboard"></i> Reporte</button></a></h1>
                <div class="box-tools pull-right">
                </div>
              </div>
              <!-- /.box-header -->
              <!-- centro -->
              <div class="panel-body table-responsive" id="listadoregistros">
                <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                  <thead>
                    <th>Opciones</th>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Usuario</th>
                    <th>Documento</th>
                    <th>Número</th>
                    <th>Total Venta</th>
                    <th>Estado</th>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                    <th>Opciones</th>
                    <th>Fecha</th>
                    <th>Proveedor</th>
                    <th>Usuario</th>
                    <th>Documento</th>
                    <th>Número</th>
                    <th>Total Venta</th>
                    <th>Estado</th>
                  </tfoot>
                </table>
              </div>
              <div class="panel-body" style="height: 100%;" id="formularioregistros">
                <form name="formulario" id="formulario" method="POST">
                  <div class="form-group col-lg-8 col-md-8 col-sm-8 col-xs-12">
                    <label>Cliente(*):</label>
                    <input type="hidden" name="idventa" id="idventa">
                    <select id="idcliente" name="idcliente" class="form-control selectpicker" data-live-search="true"
                      required>

                    </select>
                  </div>
                  <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label>Fecha(*):</label>
                    <input type="date" class="form-control" name="fecha_hora" id="fecha_hora" required="">
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <label>Tipo Comprobante(*):</label>
                    <select name="tipo_comprobante" id="tipo_comprobante" class="form-control selectpicker" required="">
                      <option value="Boleta">Boleta</option>
                      <option value="Factura">Factura</option>
                      <option value="Ticket">Ticket</option>
                    </select>
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                    <label>Serie:</label>
                    <input type="text" class="form-control" name="serie_comprobante" id="serie_comprobante" maxlength="7"
                      placeholder="Serie">
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                    <label>Número:</label>
                    <input type="text" class="form-control" name="num_comprobante" id="num_comprobante" maxlength="10"
                      placeholder="Número" required="">
                  </div>
                  <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                    <label>Impuesto:</label>
                    <input type="text" class="form-control" name="impuesto" id="impuesto" required="">
                  </div>
                  <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <a data-toggle="modal" href="#myModal">
                      <button id="btnAgregarArt" type="button" class="btn btn-primary"> <span class="fa fa-plus"></span>
                        Agregar Artículos</button>
                    </a>
                  </div>

                  <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12 table-responsive">
                    <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                      <thead style="background-color:#A9D0F5">
                        <th>Opciones</th>
                        <th>Artículo</th>
                        <th>Cantidad</th>
                        <th>Precio Venta</th>
                        <th>Descuento</th>
                        <th>Subtotal</th>
                      </thead>
                      <tfoot>
                        <th>TOTAL</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>
                          <h4 id="total">S/. 0.00</h4><input type="hidden" name="total_venta" id="total_venta">
                        </th>
                      </tfoot>
                      <tbody>

                      </tbody>
                    </table>
                  </div>

                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i>
                      Guardar</button>

                    <button id="btnCancelar" class="btn btn-danger" onclick="cancelarform()" type="button"><i
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

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog" style="width: 65% !important;">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Seleccione un Artículo</h4>
          </div>
          <div class="modal-body table-responsive">
            <table id="tblarticulos" class="table table-striped table-bordered table-condensed table-hover">
              <thead>
                <th>Opciones</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Código</th>
                <th>Stock</th>
                <th>Precio Venta</th>
                <th>Imagen</th>
              </thead>
              <tbody>

              </tbody>
              <tfoot>
                <th>Opciones</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Código</th>
                <th>Stock</th>
                <th>Precio Venta</th>
                <th>Imagen</th>
              </tfoot>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Fin modal -->
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
      //Cargamos los items al select cliente
      $.post("../ajax/venta.php?op=selectCliente", function (r) {
        $("#idcliente").html(r);
        $('#idcliente').selectpicker('refresh');
      });
      $('#mVentas').addClass("treeview active");
      $('#lVentas').addClass("active");
    }

    //Función limpiar
    function limpiar() {
      $("#idcliente").val("");
      $("#cliente").val("");
      $("#serie_comprobante").val("");
      $("#num_comprobante").val("");
      $("#impuesto").val("0");

      $("#total_venta").val("");
      $(".filas").remove();
      $("#total").html("0");

      //Obtenemos la fecha actual
      var now = new Date();
      var day = ("0" + now.getDate()).slice(-2);
      var month = ("0" + (now.getMonth() + 1)).slice(-2);
      var today = now.getFullYear() + "-" + (month) + "-" + (day);
      $('#fecha_hora').val(today);

      //Marcamos el primer tipo_documento
      $("#tipo_comprobante").val("Boleta");
      $("#tipo_comprobante").selectpicker('refresh');
    }

    //Función mostrar formulario
    function mostrarform(flag) {
      //limpiar();
      if (flag) {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        //$("#btnGuardar").prop("disabled",false);
        $("#btnagregar").hide();
        listarArticulos();

        $("#btnGuardar").hide();
        $("#btnCancelar").show();
        $("#btnAgregarArt").show();
        detalles = 0;
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
            url: '../ajax/venta.php?op=listar',
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


    //Función ListarArticulos
    function listarArticulos() {
      tabla = $('#tblarticulos').dataTable(
        {
          "aProcessing": true,//Activamos el procesamiento del datatables
          "aServerSide": true,//Paginación y filtrado realizados por el servidor
          dom: 'Bfrtip',//Definimos los elementos del control de tabla
          buttons: [

          ],
          "ajax":
          {
            url: '../ajax/venta.php?op=listarArticulosVenta',
            type: "get",
            dataType: "json",
            error: function (e) {
              console.log(e.responseText);
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
      //$("#btnGuardar").prop("disabled",true);
      var formData = new FormData($("#formulario")[0]);

      $.ajax({
        url: "../ajax/venta.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function (datos) {
          bootbox.alert(datos);
          mostrarform(false);
          listar();
        }

      });
      limpiar();
    }

    function mostrar(idventa) {
      $.post("../ajax/venta.php?op=mostrar", { idventa: idventa }, function (data, status) {
        data = JSON.parse(data);
        mostrarform(true);

        $("#idcliente").val(data.idcliente);
        $("#idcliente").selectpicker('refresh');
        $("#tipo_comprobante").val(data.tipo_comprobante);
        $("#tipo_comprobante").selectpicker('refresh');
        $("#serie_comprobante").val(data.serie_comprobante);
        $("#num_comprobante").val(data.num_comprobante);
        $("#fecha_hora").val(data.fecha);
        $("#impuesto").val(data.impuesto);
        $("#idventa").val(data.idventa);

        //Ocultar y mostrar los botones
        $("#btnGuardar").hide();
        $("#btnCancelar").show();
        $("#btnAgregarArt").hide();
      });

      $.post("../ajax/venta.php?op=listarDetalle&id=" + idventa, function (r) {
        $("#detalles").html(r);
      });
    }

    //Función para anular registros
    function anular(idventa) {
      bootbox.confirm("¿Está Seguro de anular la venta?", function (result) {
        if (result) {
          $.post("../ajax/venta.php?op=anular", { idventa: idventa }, function (e) {
            bootbox.alert(e);
            tabla.ajax.reload();
          });
        }
      })
    }

    //Declaración de variables necesarias para trabajar con las compras y
    //sus detalles
    var impuesto = 18;
    var cont = 0;
    var detalles = 0;
    //$("#guardar").hide();
    $("#btnGuardar").hide();
    $("#tipo_comprobante").change(marcarImpuesto);

    function marcarImpuesto() {
      var tipo_comprobante = $("#tipo_comprobante option:selected").text();
      if (tipo_comprobante == 'Factura') {
        $("#impuesto").val(impuesto);
      }
      else {
        $("#impuesto").val("0");
      }
    }

    function agregarDetalle(idarticulo, articulo, precio_venta) {
      var cantidad = 1;
      var descuento = 0;

      if (idarticulo != "") {
        var subtotal = cantidad * precio_venta;
        var fila = '<tr class="filas" id="fila' + cont + '">' +
          '<td><button type="button" class="btn btn-danger" onclick="eliminarDetalle(' + cont + ')">X</button></td>' +
          '<td><input type="hidden" name="idarticulo[]" value="' + idarticulo + '">' + articulo + '</td>' +
          '<td><input type="number" name="cantidad[]" id="cantidad[]" value="' + cantidad + '"></td>' +
          '<td><input type="number" name="precio_venta[]" id="precio_venta[]" value="' + precio_venta + '"></td>' +
          '<td><input type="number" name="descuento[]" value="' + descuento + '"></td>' +
          '<td><span name="subtotal" id="subtotal' + cont + '">' + subtotal + '</span></td>' +
          '<td><button type="button" onclick="modificarSubototales()" class="btn btn-info"><i class="fa fa-refresh"></i></button></td>' +
          '</tr>';
        cont++;
        detalles = detalles + 1;
        $('#detalles').append(fila);
        modificarSubototales();
      }
      else {
        alert("Error al ingresar el detalle, revisar los datos del artículo");
      }
    }

    function modificarSubototales() {
      var cant = document.getElementsByName("cantidad[]");
      var prec = document.getElementsByName("precio_venta[]");
      var desc = document.getElementsByName("descuento[]");
      var sub = document.getElementsByName("subtotal");

      for (var i = 0; i < cant.length; i++) {
        var inpC = cant[i];
        var inpP = prec[i];
        var inpD = desc[i];
        var inpS = sub[i];

        inpS.value = (inpC.value * inpP.value) - inpD.value;
        document.getElementsByName("subtotal")[i].innerHTML = inpS.value;
      }
      calcularTotales();

    }
    function calcularTotales() {
      var sub = document.getElementsByName("subtotal");
      var total = 0.0;

      for (var i = 0; i < sub.length; i++) {
        total += document.getElementsByName("subtotal")[i].value;
      }
      $("#total").html("S/. " + total);
      $("#total_venta").val(total);
      evaluar();
    }

    function evaluar() {
      if (detalles > 0) {
        $("#btnGuardar").show();
      }
      else {
        $("#btnGuardar").hide();
        cont = 0;
      }
    }

    function eliminarDetalle(indice) {
      $("#fila" + indice).remove();
      calcularTotales();
      detalles = detalles - 1;
      evaluar()
    }

    init();
  </script>
<?php
}
ob_end_flush();
?>