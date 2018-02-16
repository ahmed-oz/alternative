<?php include "include/db-connect.php";?>
<?php mysql_query("SET NAMES utf8;");?>
<?php

$query = @mysql_query("SELECT * FROM auto, concessionari_auto WHERE auto.id_status = 3" );
    $quanti = mysql_num_rows($query);
	echo $quanti." sono le auto bloccate attualmente<br>";	
	
$i=0;
while ($i < $quanti) {
$row = mysql_fetch_assoc($query);
$data_blocco_fine = $row['data_blocco_fine'];
$id_auto = $row['id'];

echo "data_blocco_fine ->". $data_blocco_fine;	

$data = date("Y-m-d H:i:s", mktime(date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
echo "<br>data_adesso ->". $data;

if ($data > $data_blocco_fine)
    {
		echo "<br><br>superati i tre giorni di blocco, rimetto in vetrina<br>";
		$changestaus = @mysql_query("UPDATE auto SET id_status =2 WHERE id='$id_auto'");
    }
    else
    {
	
		echo "<br><br>ancora non superati i tre giorni di blocco, non faccio nulla<br>";
}
$i++; 
} 
		
?>
<?php include "include/db-connect-close.php";?>