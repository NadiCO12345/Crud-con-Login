<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Usuario</title>
    <link rel="stylesheet" type="text/css" href="estilos.css">
</head>
<body>

<?php
    // Incluir el archivo de conexión a la base de datos
    require 'conexion.php';

    // Mostrar errores en PHP (solo para desarrollo)
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Proceso de registro
    if (!empty($_POST['registrar'])) {
        if (empty($_POST['usuario']) || empty($_POST['password'])) {
            echo "<script language='JavaScript'>
                console.log('Los datos están vacíos para registrar');
            </script>";
        } else {
            $usuario = $_POST['usuario'];
            $password = $_POST['password'];

            // Comprobar si la conexión a la base de datos está bien
            if ($conexion->connect_error) {
                die("Conexión fallida: " . $conexion->connect_error);
            }

            // Insertar el nuevo usuario y contraseña
            $stmt = $conexion->prepare("INSERT INTO login (usuario, password) VALUES (?, ?)");
            if (!$stmt) {
                die("Error en la preparación de la consulta: " . $conexion->error);
            }

            $stmt->bind_param("ss", $usuario, $password);

            if ($stmt->execute()) {
                // Redirigir de vuelta al login después del registro
                echo "<script language='JavaScript'>
                    console.log('Usuario registrado correctamente');
                    window.location.href = 'login.php'; // Redirige al formulario de login
                </script>";
            } else {
                echo "<script language='JavaScript'>
                    console.log('Error al registrar usuario');
                </script>";
            }

            // Cerrar la consulta
            $stmt->close();
        }
    }
?>

    <div class="container-general">
        <div class="form-container">
            <h1>Registrar Usuario</h1>
            <form name="formulario" action="" method="post">
                <div class="inputfield"><input type="text" name="usuario" placeholder="Ingresar usuario" required></div>
                <div class="inputfield"><input type="password" name="password" placeholder="Ingresar contraseña" required></div>
                <div class="btn-field">
                    <input type="submit" name="registrar" value="Registrar">
                    <a href="login.php">Volver al Login</a> <!-- Link para volver al login -->
                </div>
            </form>
        </div>
    </div>
</body>
</html>
