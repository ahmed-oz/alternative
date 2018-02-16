<?php
/*
 ** Change PHP  MySQL Functions to PHP MySQLI Functions
 ** Aj Osman
 ** 16-02-2018
 ** Build a new function to replace mysql_result()
*/

ob_start();

include "include/livello2.php";
include "include/db-connect.php";
include "include/protezione.php";
include "include/functions.php";

mysqli_query($conn, 'SET character_set_client = \'utf8\'');

$id_concessionaria = intval($_POST['id_concessionaria']);

$sql = "SELECT * FROM concessionari WHERE id_concessionaria = $id_concessionaria AND id_status <> 0";
$query = mysqli_query($conn, $sql);
$res_num = mysqli_num_rows($query);
if ($res_num > 0){
	$rs = mysqli_fetch_array($query);
}
else {
	goToPage("gestione_clienti.php?msg=3");
	die;
}

function normalizeFields($fld) {
	$fld = htmlspecialchars(trim($fld));
	$fld = addslashes($fld);
	return $fld;
}

$nome_concessionaria = normalizeFields($_POST['nome_concessionaria']);
$login = normalizeFields($_POST['login']);
$indirizzo = normalizeFields($_POST['indirizzo']);
$citta = normalizeFields($_POST['citta']);
$id_provincia = normalizeFields($_POST['id_provincia']);
$email = normalizeFields($_POST['email']);
$sito_web = normalizeFields($_POST['sito_web']);
$id_livello = normalizeFields($_POST['id_livello']);
$telefono = normalizeFields($_POST['telefono']);
$fax = normalizeFields($_POST['fax']);
$note = normalizeFields($_POST['note']);

// eseguo la query
$sqlupdate = "UPDATE concessionari SET nome_concessionaria = '$nome_concessionaria', indirizzo = '$indirizzo', citta = '$citta', id_provincia = '$id_provincia', email = '$email', sito_web = '$sito_web', id_livello = '$id_livello', telefono = '$telefono', fax = '$fax', note = '$note' WHERE id_concessionaria = '$id_concessionaria' ";
$sql = mysqli_query($conn, $sqlupdate);

goToPage("gestione_clienti.php?msg=4");

?>

<?php include "include/db-connect-close.php";?>