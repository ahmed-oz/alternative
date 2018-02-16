<?php
/*
 ** Change PHP  MySQL Functions to PHP MySQLI Functions
 ** Aj Osman
 ** 16-02-2018
 ** Build a new function to replace mysql_result()
*/

include "include/livello3.php";
include "include/db-connect.php";
include "include/protezione.php";

mysqli_query($conn, 'SET character_set_client = \'utf8\'');

$id_status = 0;

if (isset($_GET['id'])) {
$id = $_GET['id']; 
//Eseguo la query
  $query = mysqli_query($conn,"SELECT id_concessionaria FROM concessionari WHERE id_concessionaria = '$id' ");
 
$res_num = mysqli_num_rows($query);
if ($res_num == 0)
{
 // nessun concessionario presente con questo id
goToPage("add_concessionari.php?msg=3");
		die;

}else {
 
$sql = mysqli_query($conn,"UPDATE concessionari SET id_status = '$id_status' WHERE id_concessionaria = '$id' ");

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