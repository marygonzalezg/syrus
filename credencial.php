<?php
$username="mauro";
$password="mauro132";
$database="mauro-syrusdb";
?>

<?php
function parseToXML($htmlStr)
{
$xmlStr=str_replace('<','&lt;',$htmlStr);
$xmlStr=str_replace('>','&gt;',$xmlStr);
$xmlStr=str_replace('"','&quot;',$xmlStr);
$xmlStr=str_replace("'",'&#39;',$xmlStr);
$xmlStr=str_replace("&",'&amp;',$xmlStr);
return $xmlStr;
}

// Opens a connection to a MySQL server
$connection= mysqli_connect('localhost','mauro','mauro132');
if (!$connection) {
  die('Not connected : ' . mysqli_error($connection));
}

// Set the active MySQL database
$db_selected = mysqli_select_db($connection, 'syrusdb');
if (!$db_selected) {
  die ('Can\'t use db : ' . mysqli_error($connection));
}

// Select all the rows in the markers table
$query = "SELECT * From location ORDER BY id DESC LIMIT 1";
$result= mysqli_query($connection, $query);
if (!$result) {
  die('Invalid query: ' . mysqli_error($connection));    }

header("Content-type: text/xml");

// Start XML file, echo parent node
echo '<locations>';

// Iterate through the rows, printing XML nodes for each
while ($fila = @mysqli_fetch_assoc($result)){
// Add to XML document node
echo '<location_ ';
echo 'Lat="' . $fila['latitud'] . '" ';
echo 'Lng="' . $fila['longitud'] . '" ';
echo 'Fecha="' . $fila['Fecha'] .'" ';
echo 'Hora="' . $fila['Hora'] .'" ';
echo '/>';
}

// End XML file
echo '</locations>';

?>
