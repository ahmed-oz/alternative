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


$id_gallery_auto = intval($_GET['id_gallery_auto']);

$query = mysqli_query($conn,"SELECT * FROM `gallery_auto` WHERE `id_gallery_auto`=$id_gallery_auto;");

if($query) {
	$Img = mysqli_fetch_object($query);
	$query = mysqli_query($conn, "DELETE FROM `gallery_auto` WHERE `id_gallery_auto`=$id_gallery_auto;");
	@unlink($_SERVER['DOCUMENT_ROOT'] . '/public'.$Img->nome_foto);
	goToPage("view_auto.php?id=".$Img->id_auto."&msg=9");
} else {
	goToPage("view_auto.php?id=".$Img->id_auto."&msg=99");
}

?>
<?php include "include/db-connect-close.php";?>