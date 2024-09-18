<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud en php</title>
    <link rel="stylesheet" type="text/css" href="estilos.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans&family=Lexend:wght@100..900&family=Poppins:wght@600&family=Short+Stack&display=swap" rel="stylesheet">
</head>
<body>
    <?php 
    
    include("conexion.php");
    //select * from alumno
    $sql="select * from alumno";
    $resultado=mysqli_query($conexion, $sql);

    ?>
    <div class="container-index">
    <h1>Lista de Estudiantes</h1>
    <div class="containerbutton">
    <a  class="buttonagregar" href="agregar.php">Nuevo estudiante</a>
</div>
    <div class="container">
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Edad</th>
                <th>Correo</th>
                <th>DNI</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while($filas=mysqli_fetch_assoc($resultado)){
            ?>
            <tr>
                <td><?php echo $filas['id'] ?></td>
                <td><?php echo $filas['nombre'] ?></td>
                <td><?php echo $filas['apellido'] ?></td>
                <td><?php echo $filas['edad'] ?></td>
                <td><?php echo $filas['correo'] ?></td>
                <td><?php echo $filas['dni'] ?></td>
                <td>
                <?php echo "<a href='editar.php?id=".$filas['id']."'>
                    <img src='img/edit.png' alt='Editar'>
                    </a>";?>
                <?php echo "<a href='eliminar.php?id=".$filas['id']."'>
                <img src='img/delete.png' alt='Eliminar'>
                </a>";?>
            </td>
            </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
    <?php
    mysqli_close($conexion);
    ?>
    </div>
    </div>
</body>
</html>