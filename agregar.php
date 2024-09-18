<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Estudiante</title>
    <link rel="stylesheet" type="text/css" href="estilos.css">
    <script>

function validarFormulario() {
            // Obtener los valores de los campos del formulario
            var nombre = document.forms["formulario"]["nombre"].value;
            var apellido = document.forms["formulario"]["apellido"].value;
            var edad = document.forms["formulario"]["edad"].value;
            var correo = document.forms["formulario"]["correo"].value;
            var dni = document.forms["formulario"]["dni"].value;

            // Validar campo Nombre
            if (nombre === "") {
                alert("El campo Nombre es obligatorio.");
                return false;
            }

            // Validar campo Apellido
            if (apellido === "") {
                alert("El campo Apellido es obligatorio.");
                return false;
            }

            // Validar campo Edad
            if (edad === "") {
                alert("El campo Edad es obligatorio.");
                return false;
            } else if (!/^\d+$/.test(edad)) {
                alert("La edad debe ser un número entero positivo.");
                return false;
            }

            // Validar campo Correo
            if (correo === "") {
                alert("El campo Correo es obligatorio.");
                return false;
            } else {
                var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(correo)) {
                    alert("El correo electrónico no es válido.");
                    return false;
                }
            }

            // Validar campo DNI
            if (dni === "") {
                alert("El campo DNI es obligatorio.");
                return false;
            } else if (!/^\d{8}$/.test(dni)) {
                alert("El DNI debe contener exactamente 9 dígitos.");
                return false;
            }

            // Si todo está bien, permitir el envío del formulario
            return true;
        }
    </script>
</head>
<body>
    <?php
    if (isset($_POST['enviar'])) {
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $edad = $_POST['edad'];
        $correo = $_POST['correo'];
        $dni = $_POST['dni'];

        include("conexion.php");

        // Prepara la declaración para evitar inyección SQL
        $stmt = $conexion->prepare("INSERT INTO alumno (nombre, apellido, edad, correo, dni) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $nombre, $apellido, $edad, $correo, $dni);

        if ($stmt->execute()) {
            echo "<script language='JavaScript'>
                console.log('Los datos fueron ingresados correctamente');
                window.location.assign('index.php');
            </script>";
        } else {
            echo "<script language='JavaScript'>
                console.log('ERROR: No se pudieron ingresar los datos');
                window.location.assign('index.php');
            </script>";
        }

        $stmt->close();
        $conexion->close();
    }
    ?>
    <div class="container-general">
    <div class="form-container">
    <h1>Agregar Nuevo Alumno</h1>
    <form name="formulario" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" onsubmit="return validarFormulario()">
        <div class="inputfield"><input type="text" name="nombre" placeholder="Nombre" required></div>
        <div class="inputfield"><input type="text" name="apellido" placeholder="Apellido" required></div>
        <div class="inputfield"><input type="text" name="edad" placeholder="Edad" required></div>
        <div class="inputfield"><input type="text" name="correo" placeholder="Correo" required></div>
        <div class="inputfield"><input type="text" name="dni" placeholder="DNI" required></div>
        <div class="btn-field">
        <input type="submit" name="enviar" value="Agregar">
        <a href="index.php">Regresar</a>
        </div>

    </form>
</div>
</div>
</body>
</html>
