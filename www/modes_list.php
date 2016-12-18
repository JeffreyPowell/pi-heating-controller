<!DOCTYPE HTML>

<html><head>
<meta http-equiv="refresh" content="30">
</head><body bgcolor='#080808'>
<font color='#808080' size ='4' face='verdana'>
    
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
    
$servername = "localhost";
$username = "pi";
$password = "password";
$dbname = "pi_heating_db";
    
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
 
echo "<font color='#808080' size ='9' face='verdana'>Timers</font>";
echo "<div align='center'>";
$sql = "SELECT * FROM modes;";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
  echo '<table>';
  while($row = mysqli_fetch_assoc($result)) {
      
    $id = $row["id"];
      
    echo '<tr>';
      
    echo '<td>';
    echo '* '.$row["id"].' * '.$row["name"].' * '.$row["value"].' *';
    echo '</td>';
      
    echo '<td>';
    echo "<form method='get' action='/modes-edit.php?id=".$id."'>";
    echo "<input type='submit' name='id' value='".$id."'></form>";
    echo '</td>';
  
    echo '<td>';
    echo "<form method='get action='/modes-delete.php?id=".$id."'>";
    echo "<input type='submit' name='delete' value='Delete'></form>";
    echo '</td>';
      
    echo '</tr>';
  }
  echo "</table>";
    
}
mysqli_close($conn);
//exit;
function create_graph($rrdfile, $output, $start, $title, $height, $width) {
    
  $options = array(
    "--slope-mode",
    "--start", $start,
    "--title=$title",
    "--vertical-label=Temperature",
    "--lower=0",
    "--height=$height",
    "--width=$width",
    "-cBACK#161616",
    "-cCANVAS#1e1e1e",
    "-cSHADEA#000000",
    "-cSHADEB#000000",
    "-cFONT#c7c7c7",
    "-cGRID#888800",
    "-cMGRID#ffffff",
    "-nTITLE:10",
    "-nAXIS:12",
    "-nUNIT:10",
    "-y 1:5",
    "-cFRAME#ffffff",
    "-cARROW#000000",
    "DEF:callmax=$rrdfile:data:MAX",
    "CDEF:transcalldatamax=callmax,1,*",
    "AREA:transcalldatamax#a0b84240",
    "LINE4:transcalldatamax#a0b842",
#    "LINE4:transcalldatamax#a0b842:Calls",
#    "COMMENT:\\n",
#    "GPRINT:transcalldatamax:LAST:Calls Now %6.2lf",
#    "GPRINT:transcalldatamax:MAX:Data %6.2lf"
    "COMMENT:\\n"
  );
 $ret = rrd_graph( $output, $options );
  if (! $ret) {
    echo "<b>Graph error: </b>".rrd_error()."\n";
  }
}
?>

</font>
</div>
</body>
</html>
