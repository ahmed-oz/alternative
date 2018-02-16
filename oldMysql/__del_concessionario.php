<?php include "include/livello3.php";?>
<?php include "include/db-connect.php";?>
<?php include "include/protezione.php";?>
<?php mysql_query("SET NAMES utf8;");?>
<?php
$id_status = 0;

if (isset($_GET['id'])) {
$id = $_GET['id']; 
//Eseguo la query
  $query = @mysql_query("SELECT id_concessionaria FROM concessionari WHERE id_concessionaria = '$id' ");
 
$res_num = mysql_num_rows($query);
if ($res_num == 0)
{
 // nessun concessionario presente con questo id
goToPage("add_concessionari.php?msg=3");
		die;

}else {
 
$sql = @mysql_query("UPDATE concessionari SET id_status = '$id_status' WHERE id_concessionaria = '$id' ");

 // concessionario inserito
goToPage("gestione_concessionari.php?msg=2");
die;

 }
  // nessun id
//header("Location: add_concessionari.php?msg=3");
		//die;
 }		
?>
<?php include "include/db-connect-close.php";?>