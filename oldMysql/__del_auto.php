<?php include "include/livello2.php";?>
<?php include "include/db-connect.php";?>
<?php include "include/protezione.php";?>
<?php mysql_query("SET NAMES utf8;");?>
<?php
$id = intval($_GET['id']);
$id_status = 0;

$page_referer=parse_url($_SERVER['HTTP_REFERER']);
$page_back = $page_referer['path'];
$qs = $page_referer['query'];
if($qs=='') {
	$page_back .= '?';
}
else {
	$page_back .= '?' . $qs . '&';
}

if ($id>0) { 
	//Eseguo la query
    $query = @mysql_query("SELECT id, id_status FROM auto WHERE id= '$id'");	  
	$res_num = mysql_num_rows($query);
	if ($res_num == 0) {
		// nessuna auto presente con questo id
		goToPage($page_back."msg=99");
		die();
	}
	else {
		//$id_status = mysql_result($query,0,"id_status");
		if( $_SESSION["id_livello_sessione"] <= 2 ){
			$risultati = @mysql_query("SELECT id_status FROM auto WHERE id= '$id' ");
			$id_status = mysql_result($risultati,0,"id_status");
			if( $id_status <= 3 )
			 $sql = @mysql_query("UPDATE auto SET id_status = '0' WHERE id = '$id' ");
		}
		else {
			 $sql = @mysql_query("UPDATE auto SET id_status = '$id_status' WHERE id = '$id' ");
		}
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