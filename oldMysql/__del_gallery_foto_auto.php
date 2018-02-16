<?php include "include/livello2.php";?>
<?php include "include/db-connect.php";?>
<?php include "include/protezione.php";?>
<?php mysql_query("SET NAMES utf8;");?>
<?php

$id_gallery_auto = intval($_GET['id_gallery_auto']);

$query = mysql_query("SELECT * FROM `gallery_auto` WHERE `id_gallery_auto`=$id_gallery_auto;");

if($query) {
	$Img = mysql_fetch_object($query);
	$query = mysql_query("DELETE FROM `gallery_auto` WHERE `id_gallery_auto`=$id_gallery_auto;");
	@unlink($_SERVER['DOCUMENT_ROOT'] . '/public'.$Img->nome_foto);
	goToPage("view_auto.php?id=".$Img->id_auto."&msg=9");
} else {
	goToPage("view_auto.php?id=".$Img->id_auto."&msg=99");
}

?>
<?php include "include/db-connect-close.php";?>