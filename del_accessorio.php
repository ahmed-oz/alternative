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


$id = intval($_GET['id']);
$id_status = 0;

$page_referer=parse_url($_SERVER['HTTP_REFERER']);
$page_back = $page_referer['path'];
$qs = $page_referer['query'];
if($qs=='') {
	$page_back .= '?';
}
else {
	$page_back .= '&';
}

if ($id>0) { 
//Eseguo la query
    $query = mysqli_query($conn,"SELECT id FROM accessori WHERE id= '$id'");
	$res_num = mysqli_num_rows($query);
	if ($res_num == 0) {
		// nessuna auto presente con questo id
		goToPage($page_back."msg=99");
		die();
	}
	else {
		$sql = mysqli_query($conn, "DELETE FROM accessori WHERE id = '$id'");
		// auto eliminata
		goToPage($page_back."msg=3");
		die();
	}
}
else {
	goToPage($page_back."msg=99");
	die();
}		
?>