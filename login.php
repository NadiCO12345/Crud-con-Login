<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="estilos.css">
</head>
<body>

<?php
    // Incluir el archivo de conexión a la base de datos
    require 'conexion.php'; // Asegúrate de que este archivo esté en la misma carpeta o ajusta la ruta

    // Mostrar errores en PHP (solo para desarrollo)
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    if (!empty($_POST['enviar'])) {
        if (empty($_POST['usuario']) || empty($_POST['password'])) {
            echo "<script language='JavaScript'>
                console.log('Los datos están vacíos');
            </script>";
        } else {
            $usuario = $_POST['usuario'];
            $password = $_POST['password'];

            // Comprobar si la conexión a la base de datos está bien
            if ($conexion->connect_error) {
                die("Conexión fallida: " . $conexion->connect_error);
            }

            // Usar sentencias preparadas para evitar inyecciones SQL
            $stmt = $conexion->prepare("SELECT * FROM login WHERE usuario = ? AND password = ?");
            if (!$stmt) {
                die("Error en la preparación de la consulta: " . $conexion->error);
            }

            $stmt->bind_param("ss", $usuario, $password);
            $stmt->execute();
            $resultado = $stmt->get_result();

            // Verificar si se encontró el usuario
            if ($resultado->num_rows > 0) {
                header("Location: index.php");
                exit();
            } else {
                echo "<script language='JavaScript'>
                    console.log('Acceso denegado');
                </script>";
            }

            // Cerrar la consulta
            $stmt->close();
        }
    }
?>

    <div class="container-general">
        <div class="form-container">
            <h1>Login</h1>
            <form name="formulario" action="" method="post">
                <div class="inputfield"><input type="text" name="usuario" placeholder="Ingresar usuario" required></div>
                <div class="inputfield"><input type="password" name="password" placeholder="Ingresar contraseña" required></div>
                <div class="btn-field">
                    <input type="submit" name="enviar" value="Ingresar">
                    <a href="registrarlogin.php">Registrar</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
