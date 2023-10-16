<?php
session_start();

use Datos\Consulta;

// Incluir el archivo de consulta.php que contiene la clase Consulta
include_once "../datos/consulta.php";

if (isset($_POST['nombre_usuario']) && isset($_POST['contrasena'])) {
    $nombre_usuario_ingresado = $_POST['nombre_usuario'];
    $contrasena_ingresada = $_POST['contrasena'];

    // Crear una instancia de la clase Consulta
    $consulta = new Consulta();

    // Validar el inicio de sesión usando la función validar de la clase Consulta
    $usuario = $consulta->validar($nombre_usuario_ingresado, $contrasena_ingresada);

    // Cerrar la conexión después de usarla
    $consulta->cerrarConexion();

    if ($usuario != null) {
        $_SESSION['usuario'] = $usuario->id_usuario;
        $_SESSION['nombre'] = $usuario->nombre;

        // Redireccionar según el nombre de usuario
        if ($usuario->nombre === 'adminalan') {
            header('Location: admin.php');
            exit;
        } elseif ($usuario->nombre === 'secrealan') {
            header('Location: secre.php');
            exit;
        } else {
            // Redireccionar a una página predeterminada para usuarios no reconocidos
            header('Location: alan.php');
            exit;
        }
    } else {
        // Mostrar mensaje de error en la página de inicio de sesión
        echo '<script>
                alert("Usuario o contraseña inválidos.");
                window.location.href = "alan.php";
              </script>';
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/form.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script><!-- cdn para estilos de alerta -->
    <title>Alan</title>
</head>

<body>
    <div class="box">
        <div class="container">
            <div class="top-header">
                <header>Iniciar Sesión</header>
            </div>
            <form action="alan.php" method="POST">
                <div class="input-field">
                    <input type="text" class="input" name="nombre_usuario" placeholder="Usuario" required>
                    <i class="bx bx-user"></i>
                </div>
                <div class="input-field">
                    <input type="password" class="input" name="contrasena" placeholder="Contraseña" required>
                    <i class="bx bx-lock-alt"></i>
                </div>
                <div class="input-field">
                    <input type="submit" class="submit" value="Login">
                </div>
                <div class="bottom">
                    <div class="left">
                        <input type="checkbox" id="check">
                        <label for="check"> Remember Me</label>
                    </div>
                    <div class="right">
                        <label><a href="#">Forgot password?</a></label>
                    </div>
                </div>
            </form>

        </div>
    </div>
</body>

</html>