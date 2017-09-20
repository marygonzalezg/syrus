<?php
$conexion=mysqli_connect('localhost','mauro','mauro132','syrusdb') or die ('Connection error');
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title> Syrus location</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="style.php" />
</head>
    <body>
        <div id="table">
        <table>
          <thead>
            <tbody>
              <tr>
              <th> Latitud  </th>
              <th> Longitud </th>
              <th> Fecha    </th>
              <th> Hora     </th>
              <tr/>
            </tbody>
          </thead>
            <?php
            $query = "SELECT * From location ORDER BY id DESC LIMIT 1";
            $resultado= mysqli_query($conexion,$query);
            while ($fila = mysqli_fetch_array($resultado)){
              ?>
              <tr>
              <td><?php echo $fila ['longitud']?> </td>
              <?php $Longitud_x = $fila ['longitud']; ?>
              <td><?php echo $fila ['latitud']?> </td>
              <?php $Latitud_x = $fila ['latitud']; ?>
              <td><?php echo $fila ['Fecha']?> </td>
              <td><?php echo $fila ['Hora']?> </td>
              </tr>
            <?php }
            ?>
        </table>
        </div>
      <div id="sending">
        <?php
        // Set session variables
        //$Latitud_x = 'latitud';
        $_SESSION["Latitud_x"]= $Latitud_x;
        $_SESSION["Longitud_x"]= $Longitud_x;
        ?>
        </div>
    </body>
        <script type="text/javascript" src="jquery-3.2.1.js"> </script>
        <script type="text/javascript" >
      		$(document).ready(function() {
      			setInterval(function () {
      				$('#table').load('DB.php')
      			}, 500);
      		});
      	</script>
        <script>
        function readDB(){
        }
        readDB();
        </script>
</html>
