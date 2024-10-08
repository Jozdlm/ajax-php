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
                                <h1 class="box-title">Nueva Categoría </h1>
                            </div>
                            <div class="panel-body" style="height: 400px;" id="formularioregistros">
                                <form name="formulario" id="formulario" method="POST">
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <label>Nombre:</label>
                                        <input type="hidden" name="idcategoria" id="idcategoria">
                                        <input type="text" class="form-control" name="nombre" id="nombre" maxlength="50"
                                            placeholder="Nombre" required>
                                    </div>
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <label>Descripción:</label>
                                        <input type="text" class="form-control" name="descripcion" id="descripcion"
                                            maxlength="256" placeholder="Descripción">
                                    </div>
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i>
                                            Guardar</button>

                                        <a class="btn btn-danger" href="app/categories/" type="button"><i
                                                class="fa fa-arrow-circle-left"></i> Cancelar</a>
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
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            $('#mAlmacen').addClass("treeview active");
            $('#lCategorias').addClass("active");
        })

        document.getElementById('formulario').addEventListener('submit', (e) => {
            e.preventDefault(); //No se activará la acción predeterminada del evento
            $("#btnGuardar").prop("disabled", true);
            var formData = new FormData($("#formulario")[0]);

            $.ajax({
                url: "/api/categoria.php?op=guardaryeditar",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,

                success: function (datos) {
                    bootbox.alert(datos);
                    window.location.href = "app/categories/";
                }
            });
        })
    </script>
    <?php
}
ob_end_flush();
?>