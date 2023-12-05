<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ServiManagement</title>

    <link
      href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="assets/css/menu.css" />
    <link rel="stylesheet" href="assets/css/estilos.css" />
  </head>
  <body>
    <!--Menu-->
    <nav class="navbar">
      <a href="#" class="logo">ServiManagement</a>
      <div class="nav-links">
     
    </nav>

    <main>
      <div class="contenedor__todo">
        <div class="caja__trasera">
          <div class="caja__trasera-login">
            <h3>¿Ya tienes una cuenta?</h3>
            <p>Inicia sesión para entrar en la página</p>
            <button id="btn__iniciar-sesion">Iniciar Sesión</button>
          </div>
          <div class="caja__trasera-register">
            <h3>¿Aún no tienes una cuenta?</h3>
            <p>Regístrate para que puedas iniciar sesión</p>
            <button id="btn__registrarse">Regístrarse</button>
          </div>
        </div>

        <!--Formulario de Login y registro-->
        <div class="contenedor__login-register">
          <!--Login-->
          <form action="#" method="post" class="formulario__login">
            <h2>Iniciar Sesión</h2>
            <input type="text" id="correolog" placeholder="Correo Electronico" name="correolog" require/>
            <input type="password" id="contrasenalog" placeholder="Contraseña" name="contrasenalog" require/>
            <button>Entrar</button>
          </form>

          <!--Register-->
          <form action="#" method="post" class="formulario__register">
            <h2>Regístrarse</h2>
            <input type="text" id="nombre" name="nombre" placeholder="Nombre completo" require/>
            <input type="text" id="correo" name="correo" placeholder="Correo Electronico" require/>
            <input type="text" id="user" name="user" placeholder="Usuario" require/>
            <input type="password" id="psw" name="psw" placeholder="Contraseña" require/>
            <input type="password" id="pswc" name="pswc" placeholder="Confirmar contraseña" require/>

            <button onclick="guardar()">Regístrarse</button>
          </form>
        </div>
      </div>
    </main>

      <?php include 'dtos/log_and_regis.php'; ?>
      <?php include 'dtos/regis_usr.php'; ?>

    <script src="assets/js/script.js"></script>
    <script src="/assets/js/fun.js"></script>
  </body>
</html>