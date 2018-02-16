<?php
/*
 ** Change PHP  MySQL Functions to PHP MySQLI Functions
 ** Aj Osman
 ** 16-02-2018
 ** Build a new function to replace mysql_result()
*/

include "include/livello2.php";
include "include/db-connect.php";
include "include/protezione.php";

mysqli_query($conn, 'SET character_set_client = \'utf8\'');


$id_documento = intval($_GET['id']);

$query = mysqli_query($conn,"SELECT * FROM `documenti_auto` WHERE `id_documento`=$id_documento;");

if($query) {
	$Doc = mysqli_fetch_object($query);
	$query = mysqli_query($conn,"DELETE FROM `documenti_auto` WHERE `id_documento`=$id_documento;");
	@unlink($_SERVER['DOCUMENT_ROOT'] . '/public'.$Doc->nome_documento);
	goToPage("view_auto.php?id=".$Doc->id_auto."&msg=9");
} else {
	goToPage("view_auto.php?id=".$Doc->id_auto."&msg=99");
}

?>
<?php include "include/db-connect-close.php";?>