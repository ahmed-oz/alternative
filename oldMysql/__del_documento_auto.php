<?php include "include/livello2.php";?>
<?php include "include/db-connect.php";?>
<?php include "include/protezione.php";?>
<?php mysql_query("SET NAMES utf8;");?>
<?php

$id_documento = intval($_GET['id']);

$query = mysql_query("SELECT * FROM `documenti_auto` WHERE `id_documento`=$id_documento;");

if($query) {
	$Doc = mysql_fetch_object($query);	
	$query = mysql_query("DELETE FROM `documenti_auto` WHERE `id_documento`=$id_documento;");
	@unlink($_SERVER['DOCUMENT_ROOT'] . '/public'.$Doc->nome_documento);
	goToPage("view_auto.php?id=".$Doc->id_auto."&msg=9");
} else {
	goToPage("view_auto.php?id=".$Doc->id_auto."&msg=99");
}

?>
<?php include "include/db-connect-close.php";?>