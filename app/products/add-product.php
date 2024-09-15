<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"])) {
    header("Location: /login.php");
} else {
    require $_SERVER['DOCUMENT_ROOT'] . '/app/header.php';
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
                            </div>
                            <!-- /.box-header -->
                            <!-- centro -->
                            <div class="panel-body" id="formularioregistros">
                                <form name="formulario" id="formulario" method="POST">
                                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label>Nombre(*):</label>
                                        <input type="hidden" name="idarticulo" id="idarticulo">
                                        <input type="text" class="form-control" name="nombre" id="nombre" maxlength="100"
                                            placeholder="Nombre" required>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label>Categoría(*):</label>
                                        <select id="idcategoria" name="idcategoria" class="form-control selectpicker"
                                            data-live-search="true" required></select>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label>Stock(*):</label>
                                        <input type="number" class="form-control" name="stock" id="stock" required>
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <label>Descripción:</label>
                                        <input type="text" class="form-control" name="descripcion" id="descripcion"
                                            maxlength="256" placeholder="Descripción">
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
                                        <input type="text" class="form-control" name="codigo" id="codigo"
                                            placeholder="Código Barras">
                                        <button class="btn btn-success" type="button"
                                            onclick="generarbarcode()">Generar</button>
                                        <button class="btn btn-info" type="button" onclick="imprimir()">Imprimir</button>
                                        <div id="print">
                                            <svg id="barcode"></svg>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i>
                                            Guardar</button>

                                        <a class="btn btn-danger" href="app/products/"><i class="fa fa-arrow-circle-left"></i>
                                            Cancelar</a>
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
        require $_SERVER['DOCUMENT_ROOT'] . '/app/noacceso.php';
    }
    require $_SERVER['DOCUMENT_ROOT'] . '/app/footer.php';
    ?>
    <script type="text/javascript" src="/public/js/JsBarcode.all.min.js"></script>
    <script type="text/javascript" src="/public/js/jquery.PrintArea.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            //Cargamos los items al select categoria
            $.post("/api/articulo.php?op=selectCategoria", function (r) {
                $("#idcategoria").html(r);
                $('#idcategoria').selectpicker('refresh');
            });

            $("#imagenmuestra").hide();
            $('#mAlmacen').addClass("treeview active");
            $('#lArticulos').addClass("active");
        })

        document.getElementById('formulario').addEventListener('submit', (e) => {
            e.preventDefault(); //No se activará la acción predeterminada del evento
            $("#btnGuardar").prop("disabled", true);
            var formData = new FormData($("#formulario")[0]);

            $.ajax({
                url: "/api/articulo.php?op=guardaryeditar",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (datos) {
                    bootbox.alert(datos);
                    window.location.href = "app/products/";
                }
            });
        })

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
    </script>
    <?php
}
ob_end_flush();
?>