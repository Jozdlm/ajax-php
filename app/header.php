<?php
if (strlen(session_id()) < 1)
  session_start();
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Punto de Venta - Small Bussiness</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <!-- Bootstrap 3.3.5 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css"
    integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

  <!-- Bootstrap Select 1.13.14 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="/public/css/font-awesome.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/public/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="/public/css/_all-skins.min.css">
  <link rel="apple-touch-icon" href="/public/img/apple-touch-icon.png">
  <link rel="shortcut icon" href="/public/img/favicon.ico">
  <base href="/">

  <!-- DATATABLES -->
  <link rel="stylesheet" type="text/css" href="/public/datatables/jquery.dataTables.min.css">
  <link href="/public/datatables/buttons.dataTables.min.css" rel="stylesheet" />
  <link href="/public/datatables/responsive.dataTables.min.css" rel="stylesheet" />
</head>

<body class="hold-transition skin-blue-light sidebar-mini">
  <div class="wrapper">

    <header class="main-header">

      <!-- Logo -->
      <a href="index2.html" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>AD</b>Ventas</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>ADVentas</b></span>
      </a>

      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
          <span class="sr-only">Navegación</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <!-- Messages: style can be found in dropdown.less-->

            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="/files/usuarios/<?php echo $_SESSION['imagen']; ?>" class="user-image" alt="User Image">
                <span class="hidden-xs"><?php echo $_SESSION['nombre']; ?></span>
              </a>
              <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                  <img src="/files/usuarios/<?php echo $_SESSION['imagen']; ?>" class="img-circle" alt="User Image">
                  <p>
                    www.incanatoit.com - Desarrollando Software
                    <small>www.youtube.com/jcarlosad7</small>
                  </p>
                </li>

                <!-- Menu Footer-->
                <li class="user-footer">

                  <div class="pull-right">
                    <a href="/api/usuario.php?op=salir" class="btn btn-default btn-flat">Cerrar</a>
                  </div>
                </li>
              </ul>
            </li>

          </ul>
        </div>

      </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
          <li class="header"></li>
          <?php if ($_SESSION['escritorio'] == 1): ?>
            <li id="mEscritorio">
              <a href="app/">
                <i class="fa fa-tasks"></i> <span>Escritorio</span>
              </a>
            </li>
          <?php endif; ?>

          <?php if ($_SESSION['almacen'] == 1): ?>
            <li id="mAlmacen" class="treeview">
              <a href="#">
                <i class="fa fa-laptop"></i>
                <span>Almacén</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li id="lArticulos"><a href="app/products/"><i class="fa fa-circle-o"></i> Artículos</a></li>
                <li id="lCategorias"><a href="app/categories/"><i class="fa fa-circle-o"></i> Categorías</a></li>
              </ul>
            </li>
          <?php endif; ?>

          <?php if ($_SESSION['compras'] == 1): ?>
            <li id="mCompras" class="treeview">
              <a href="#">
                <i class="fa fa-th"></i>
                <span>Compras</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li id="lIngresos"><a href="app/purchases/"><i class="fa fa-circle-o"></i> Ingresos</a></li>
                <li id="lProveedores"><a href="app/suppliers/"><i class="fa fa-circle-o"></i> Proveedores</a></li>
              </ul>
            </li>
          <?php endif; ?>

          <?php if ($_SESSION['ventas'] == 1): ?>
            <li id="mVentas" class="treeview">
              <a href="#">
                <i class="fa fa-shopping-cart"></i>
                <span>Ventas</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li id="lVentas"><a href="app/sales/"><i class="fa fa-circle-o"></i> Ventas</a></li>
                <li id="lClientes"><a href="app/customers/"><i class="fa fa-circle-o"></i> Clientes</a></li>
              </ul>
            </li>
          <?php endif; ?>

          <?php if ($_SESSION['acceso'] == 1): ?>
            <li id="mAcceso" class="treeview">
              <a href="#">
                <i class="fa fa-folder"></i> <span>Acceso</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li id="lUsuarios"><a href="app/users/"><i class="fa fa-circle-o"></i> Usuarios</a></li>
                <li id="lPermisos"><a href="app/permiso.php"><i class="fa fa-circle-o"></i> Permisos</a></li>

              </ul>
            </li>
          <?php endif; ?>

          <?php if ($_SESSION['consultac'] == 1 && $_SESSION['consultav'] == 1): ?>
            <li id="mConsultas" class="treeview">
              <a href="#">
                <i class="fa fa-bar-chart"></i> <span>Reportes y Consultas</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li id="lConsulasC">
                  <a href="app/comprasfecha.php"><i class="fa fa-circle-o"></i> Consulta Compras</a>
                </li>
                <li id="lConsulasV">
                  <a href="app/ventasfechacliente.php"><i class="fa fa-circle-o"></i> Consulta Ventas</a>
                </li>
              </ul>
            </li>
          <?php endif; ?>

          <li>
            <a href="app/ayuda.php">
              <i class="fa fa-plus-square"></i> <span>Ayuda</span>
              <small class="label pull-right bg-red">PDF</small>
            </a>
          </li>
          <li>
            <a href="app/acerca.php">
              <i class="fa fa-info-circle"></i> <span>Acerca De.</span>
              <small class="label pull-right bg-yellow">IT</small>
            </a>
          </li>

        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>