<?php 
include '../login/login.php';
session_start();
if(!verificar_usuario()){
    header("location: ../Front/login.php");
}
include '../login/tiempo.php'; 
?>
<!doctype html>
<html>
<head>
    <?php
    include 'librerias.php';
    ?>
    <title>Administrador</title>
</head>
<body class="bg-grayLighter">
    <div style="overflow: hidden;">
       <?php
       include 'menu.php';
       ?>
        <div class="bg-grayLighter" style="margin: 0px;">
                    <center>
                        <h3 class="bg-teal fg-white padding10" style="margin-bottom: 0px;text-shadow: 0px 0px 4px rgba(150, 150, 150, 1);"><span style="padding-bottom: 5px;" class="mif-wrench" ></span> Parte administrativa</h3>
                    </center>
        </div>
            <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

      // Load the Visualization API and the corechart package.
      google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        <?php 
                            include '../login/conexion.php'; 
                            $sql="select (productos.precio_v-productos.precio_n) as ganancia,SUM(detalle_pedido.cantidad)as cantidad,productos.nombre from detalle_pedido, productos where detalle_pedido.producto=productos.id GROUP BY detalle_pedido.producto";
                            $consulta=mysql_query($sql,$conexion) or die ("error ".mysql_error());
                            $numRegistros=mysql_num_rows($consulta);
                            if($numRegistros>0) {
                            while($row=mysql_fetch_array($consulta)){
                            ?>
    
        data.addRows([
                            ['<?=$row[2]?>', <?=number_format(($row[0]*$row[1]), 2, '.', '')?>]
        ]);

        
    
                            <?php }} ?>
                                    // Set chart options
        var options = {'title':'Productos que producen mayor ganancia segun la cantidad que se han vendido',
                       'width':800,
                       'height':300};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
    <div id="chart_div" style="padding-left: 280px;"></div>
        </div>
    
    <?php
    include 'footer.php';
    ?>
</body>
</html>