<?php
error_reporting(-1);
date_default_timezone_set('Europe/Rome');
ob_start();

$db = "app-alternativa-auto-it";
$host = "localhost"; /* Modificato da Gianluca - 20170111 */
$username = "app-alternativa";
$password = "arguo";

if(!$conn = @mysql_connect($host,$username,$password))
{
	echo "Impossibile connettersi a MySql<br>";
	echo mysql_errno(). ": " . mysql_error() . "\n";
	die;
}

if(!@mysql_select_db($db,$conn))
{
	echo "Impossibile selezionare il database $db";
	echo mysql_errno() . ": " . mysql_error(). "\n";
	die;
}

mysql_query("SET character_set_client = 'utf8'");
mysql_query("SET character_set_results = 'utf8'");
mysql_query("SET character_set_connection = 'utf8'");
/*mysql_query("SET NAMES 'utf8'");*/

function goToPage($url) {
	//echo "<script>window.location.replace('".$url."');</script>";
	echo "<script>window.location.href='".$url."';</script>";
	die();
}
function debug($s, $p=1) {
    echo('<pre>');
    var_dump($s);
    echo('</pre>');
    if ($p)
        die();
}
function clear_data_blocco_fine() { //elimina tupla concessionari_auto e setta id_status= 2 se data_blocco_fine è passata passata
	/* Modificato da Gianluca - 20170111 */
	/*
	$query = @mysql_query("SELECT * FROM concessionari_auto JOIN auto ON concessionari_auto.id_auto = auto.id WHERE concessionari_auto.data_blocco_fine < CURRENT_TIMESTAMP AND auto.id_status = 3" );
	$quanti = mysql_num_rows($query);
	$i=0;
	while ($i < $quanti) {
		$row = mysql_fetch_assoc($query);
		//debug($row,1);
		$query = @mysql_query("UPDATE auto SET id_status=2 WHERE id = {$row['id_auto']}" );
		$query = @mysql_query("DELETE FROM concessionari_auto WHERE id_concessionari_auto = {$row['id_concessionari_auto']}" );
		$i++;
	}
	*/
	/* Modificato da Gianluca - 20170111 */
}

function isValidDateTime($dateTime) {
    if (preg_match("/^(\d{4})-(\d{2})-(\d{2}) ([01][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/", $dateTime, $matches)) {
        if (checkdate($matches[2], $matches[3], $matches[1])) {
            return true;
        }
    }
    return false;
}

?>
