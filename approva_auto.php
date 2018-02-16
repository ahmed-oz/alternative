<?php
/*
 ** Change PHP  MySQL Functions to PHP MySQLI Functions
 ** Aj Osman
 ** 16-02-2018
*/

include "include/livello3.php";
include "include/db-connect.php";
include "include/protezione.php";

mysqli_query($conn, 'SET character_set_client = \'utf8\'');

$id = $_GET['id'];
$id_status = 2;

if (isset($_GET['id'])) { 
//Eseguo la query
  $query = mysqli_query($conn,"SELECT id FROM auto WHERE id= '$id'");
	  
$res_num = mysqli_num_rows($query);
if ($res_num == 0)
{
 // nessuna auto presente con questo id
goToPage("gestione_auto.php?msg=99");
		die;

}else {

$sql = mysqli_query($conn, "UPDATE auto SET id_status = '$id_status' WHERE id = '$id' ");

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