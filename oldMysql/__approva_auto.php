<?php include "include/livello3.php";?>
<?php include "include/db-connect.php";?>
<?php include "include/protezione.php";?>
<?php mysql_query("SET NAMES utf8;");?>
<?php
$id = $_GET['id'];
$id_status = 2;

if (isset($_GET['id'])) { 
//Eseguo la query
  $query = @mysql_query("SELECT id FROM auto WHERE id= '$id'");
	  
$res_num = mysql_num_rows($query);
if ($res_num == 0)
{
 // nessuna auto presente con questo id
goToPage("gestione_auto.php?msg=99");
		die;

}else {

$sql = @mysql_query("UPDATE auto SET id_status = '$id_status' WHERE id = '$id' ");

 // auto inserita
goToPage("gestione_auto.php?msg=5");
die;

 }
  // nessun id
goToPage("gestione_auto.php?msg=99");
		die;
}		
?>
<?php include "include/db-connect-close.php";?>