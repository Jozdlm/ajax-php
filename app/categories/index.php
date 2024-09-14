<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"])) {
    header("Location: vistas/login.html");
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
                                <h1 class="box-title">Categoría </h1>
                                <div class="box-tools pull-right">
                                    <a href="/app/reportes//rptcategorias.php" target="_blank" class="btn btn-info">
                                        <i class="fa fa-clipboard"></i> Reporte</a>
                                    <a class="btn btn-success" id="btnagregar" href="app/categories/add-category.php"><i
                                            class="fa fa-plus-circle"></i> Agregar</a>
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
            listar();
        })

        let tabla;

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
                        url: '/api/categoria.php?op=listar',
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
        function desactivar(idcategoria) {
            bootbox.confirm("¿Está Seguro de desactivar la Categoría?", function (result) {
                if (result) {
                    $.post("/api/categoria.php?op=desactivar", { idcategoria: idcategoria }, function (e) {
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
                    $.post("/api/categoria.php?op=activar", { idcategoria: idcategoria }, function (e) {
                        bootbox.alert(e);
                        tabla.ajax.reload();
                    });
                }
            })
        }
    </script>
    <?php
}
ob_end_flush();
?>