<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Estudiante</title>
    <link rel="stylesheet" type="text/css" href="estilos.css">
    <script src="validacion.js" defer></script>
    <script>
        // Función de validación del formulario
        function validarFormulario() {
            // Obtener los valores de los campos del formulario
            var nombre = document.querySelector("[name='nombre']").value;
            var apellido = document.querySelector("[name='apellido']").value;
            var edad = document.querySelector("[name='edad']").value;
            var correo = document.querySelector("[name='correo']").value;
            var dni = document.querySelector("[name='dni']").value;

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
    // Incluir el archivo de conexión
    include("conexion.php");

    // Verificar si se está enviando el formulario para actualizar
    if (isset($_POST['enviar'])) {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $edad = $_POST['edad'];
        $correo = $_POST['correo'];
        $dni = $_POST['dni'];

        // Preparar y ejecutar la consulta de actualización
        $stmt = $conexion->prepare("UPDATE alumno SET nombre=?, apellido=?, edad=?, correo=?, dni=? WHERE id=?");
        $stmt->bind_param("ssssis", $nombre, $apellido, $edad, $correo, $dni, $id);

        if ($stmt->execute()) {
            // Si la actualización fue exitosa
            echo "<script language='JavaScript'>
                console.log('Los datos fueron actualizados correctamente');
                window.location.assign('index.php');
            </script>";
        } else {
            // Si hubo un error al actualizar los datos
            echo "<script language='JavaScript'>
                console.log('ERROR: No se pudieron actualizar los datos');
                window.location.assign('index.php');
            </script>";
        }
        $stmt->close();
        $conexion->close();
    } else {
        // Obtener el ID del estudiante
        $id = isset($_GET['id']) ? $_GET['id'] : 0;

        // Preparar y ejecutar la consulta para obtener los datos del estudiante
        $stmt = $conexion->prepare("SELECT * FROM alumno WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result();

        // Verificar si se obtuvo el registro
        if ($fila = $resultado->fetch_assoc()) {
            $nombre = $fila['nombre'];
            $apellido = $fila['apellido'];
            $edad = $fila['edad'];
            $correo = $fila['correo'];
            $dni = $fila['dni'];
        }  else {
            echo "<script language='JavaScript'>
                console.log('ERROR: No se encontró el estudiante');
                window.location.assign('index.php');
            </script>";
            exit;
        }

        $stmt->close();
        $conexion->close();
    }
?>
<div class="container-general">
    <div class="form-container">
    <h1>Editar Estudiante</h1>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" onsubmit="return validarFormulario()">
        <div class="inputfield"><input type="text" name="nombre" placeholder="Nombre" value="<?php echo htmlspecialchars($nombre); ?>"></div>
        <div class="inputfield"><input type="text" name="apellido" placeholder="Apellido" value="<?php echo htmlspecialchars($apellido); ?>"></div>
        <div class="inputfield"><input type="text" name="edad"  placeholder="Edad"value="<?php echo htmlspecialchars($edad); ?>"></div>
        <div class="inputfield"><input type="text" name="correo"  placeholder="Correo" value="<?php echo htmlspecialchars($correo); ?>"></div>
        <div class="inputfield"><input type="text" name="dni" placeholder="DNI" value="<?php echo htmlspecialchars($dni); ?>"></div>

        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
        <div class="btn-field">
        <input type="submit" name="enviar" value="Actualizar">
        <a href="index.php">Regresar</a>
</div>
    </form>
</div>
</div>
</body>
</html>
