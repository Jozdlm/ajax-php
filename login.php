<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>Login - Small Business Manager</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
  <!-- Bootstrap 3.3.5 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css"
    integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../public/css/font-awesome.css" />

  <!-- Theme style -->
  <link rel="stylesheet" href="../public/css/AdminLTE.min.css" />
  <!-- iCheck -->
  <link rel="stylesheet" href="../public/css/blue.css" />

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="#"><b>Small Business Manager</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
      <p class="login-box-msg">Iniciar Sesión</p>
      <form method="post" id="frmAcceso">
        <div class="form-group has-feedback">
          <input type="text" id="logina" name="logina" class="form-control" placeholder="Usuario" />
          <span class="fa fa-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input type="password" id="clavea" name="clavea" class="form-control" placeholder="Contraseña" />
          <span class="fa fa-key form-control-feedback"></span>
        </div>
        <div class="row">
          <div class="col-xs-8"></div>
          <!-- /.col -->
          <div class="col-xs-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat">
              Ingresar
            </button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.login-box-body -->
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="../public/js/jquery-3.1.1.min.js"></script>
  <!-- Bootstrap 3.3.5 -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js"
    integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
    crossorigin="anonymous"></script>
  <!-- Bootbox -->
  <script src="../public/js/bootbox.min.js"></script>

  <script type="text/javascript" src="scripts/login.js"></script>
  <script>
    $("#frmAcceso").on("submit", function (e) {
      e.preventDefault();
      logina = $("#logina").val();
      clavea = $("#clavea").val();

      $.post(
        "/api/usuario.php?op=verificar",
        { logina: logina, clavea: clavea },
        function (data) {
          if (data != "null") {
            $(location).attr("href", "/app/");
          } else {
            bootbox.alert("Usuario y/o Password incorrectos");
          }
        }
      );
    });
  </script>
</body>

</html>