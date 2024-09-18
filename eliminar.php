<?php
// Obtener el ID del parámetro GET
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Incluir el archivo de conexión
include("conexion.php");

// Preparar la consulta de eliminación utilizando declaraciones preparadas
$stmt = $conexion->prepare("DELETE FROM alumno WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    // Si la eliminación fue exitosa
    echo "<script language='JavaScript'>
        console.log('Los datos fueron eliminados correctamente de la base de datos');
        window.location.assign('index.php');
    </script>";
} else {
    // Si hubo un error al eliminar los datos
    echo "<script language='JavaScript'>
        console.log('ERROR: Los datos NO fueron eliminados correctamente de la base de datos');
        window.location.assign('index.php');
    </script>";
}


// Cerrar la declaración y la conexión
$stmt->close();
$conexion->close();
?>
