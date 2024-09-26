<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gráfica de Edades</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <style>
        /* Estilos personalizados */
        body {
          font-family: "Poppins", system-ui;
          padding: 0;
          margin: 0;
          background-color: #d0d0d0;
        }

        .container-general {
          display: flex;
          flex-direction: column;
          justify-content: center;
          align-items: center;
          min-height: 100vh;
        }

        .chart-container {
          background-color: #2c2f35;
          padding: 50px;
          border-radius: 25px;
          width: 900px;
        }

        h1 {
          color: white;
          text-align: center;
          position: relative;
          margin-bottom: 40px;
        }

        h1::after {
          content: '';
          width: 30px;
          height: 4px;
          border-radius: 3px;
          background-color: #04bd7d;
          position: absolute;
          bottom: -12px;
          left: 50%;
          transform: translateX(-50%);
        }

        #chart_div {
          width: 900px;
          height: 500px;
        }

        .buttonagregar {
          background-color: #04bd7d;;
          color: white;
          padding: 14px 25px;
          text-decoration: none;
          border-radius: 5px;
          display: inline-block;
          margin-top: 20px;
        }
    </style>
    <script type="text/javascript">
      // Cargar Google Charts
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        // Crear el array de datos
        var data = google.visualization.arrayToDataTable([
          ['Nombre', 'Edad'],
          <?php
          include("conexion.php");
          $sql = "SELECT nombre, edad FROM alumno";
          $resultado = mysqli_query($conexion, $sql);

          // Generar los datos en formato JSON para Google Charts
          while($filas = mysqli_fetch_assoc($resultado)) {
              echo "['".$filas['nombre']."', ".$filas['edad']."],";
          }

          mysqli_close($conexion);
          ?>
        ]);

        // Configuración de la gráfica
        var options = {
          title: 'Edades de los Estudiantes',
          hAxis: {title: 'Nombre', titleTextStyle: {color: '#333'}},
          vAxis: {title: 'Edad', minValue: 0},
          chartArea: {width: '50%', height: '70%'},
          bars: 'horizontal',
          backgroundColor: '#515969',
          titleTextStyle: {color: 'white'},
          hAxis: {textStyle: {color: 'white'}, titleTextStyle: {color: 'white'}},
          vAxis: {textStyle: {color: 'white'}},
          colors: ['#04bd7d']
        };

        // Dibujar la gráfica en el contenedor 'chart_div'
        var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
</head>
<body>
    <div class="container-general">
      <div class="chart-container">
        <h1>Gráfica de Edades de los Estudiantes</h1>
        <div id="chart_div"></div>
        <a href="index.php" class="buttonagregar">Volver a la Lista de Estudiantes</a>
      </div>
    </div>
</body>
</html>
