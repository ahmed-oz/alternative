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

mysqli_query($conn, 'SET character_set_client = \'utf8\'');

$id_auto = intval($_POST['id_auto']);

if($_SESSION['id_livello_sessione']<3) {
	$sql = "SELECT COUNT(*) as my_car FROM auto WHERE id = $id_auto AND id_status = 1 AND id_concessionario = ".$_SESSION['id_utente_sessione'];
	$query = mysqli_query($conn, $sql);
	$rs = mysqli_fetch_array($query);
	if(intval($rs['my_car'])!=1) {		
		goToPage("index.php?msg=3");
		die();
	}
}

function normalizeFields($fld) {
	$fld = htmlspecialchars(trim($fld));
	$fld = addslashes($fld);
	return $fld;
}

$targa = normalizeFields($_POST['targa']);
$marca = normalizeFields($_POST['marca']);
$modello = normalizeFields($_POST['modello']);
$allestimento = normalizeFields($_POST['allestimento']);
$km= normalizeFields($_POST['km']);
$cv= normalizeFields($_POST['cv']);
$cc= normalizeFields($_POST['cc']);
$alimentazione= normalizeFields($_POST['alimentazione']);
$kw=  normalizeFields($_POST['cv'])*0.74;
$date_pieces = explode("/", $_POST['immatricolazione']);
$immatricolazione = normalizeFields($date_pieces[1] . "-" . $date_pieces[0] . "-01");
$colore = normalizeFields($_POST['colore']);
$ubicazione = normalizeFields($_POST['ubicazione']);
$listino = normalizeFields($_POST['listino']);
$danni = normalizeFields($_POST['danni']);
$danni_dettaglio = normalizeFields($_POST['danni_dettaglio']);
$prezzo = normalizeFields($_POST['prezzo']);
$prezzo_operatore = normalizeFields($_POST['prezzo_operatore']);
$note= addslashes($_POST['note']);
$telaio = normalizeFields($_POST['telaio']);
$iva_deducibile = ( isset( $_POST['iva_deducibile'] ) ) ? 1 : 0; 

if(isset($_POST['concessionaria']) && !empty($_POST['concessionaria'])) {
	$concessionaria = intval($_POST['concessionaria']);
}

//eseguo la query
$sqlupdate = "UPDATE auto SET targa= '$targa', telaio= '$telaio', marca = '$marca', modello='$modello', allestimento='$allestimento', km='$km', cv='$cv', cc='$cc', alimentazione='$alimentazione', kw='$kw', immatricolazione='$immatricolazione', colore='$colore', ubicazione='$ubicazione', listino='$listino', danni='$danni', danni_dettaglio='$danni_dettaglio', prezzo='$prezzo', prezzo_operatore='$prezzo_operatore', note='$note', iva_deducibile='$iva_deducibile' ";

if ($_SESSION['id_livello_sessione'] >= 3 && isset($_POST['concessionaria']) && !empty($_POST['concessionaria'])) {
	$sqlupdate .= ", id_concessionario='".intval($_POST['concessionaria'])."'";
}

$sqlupdate .= " WHERE id ='$id_auto' ";
//echo $sqlupdate; die;

$sql = mysqli_query($conn, $sqlupdate);

//cancello optional attuali
$sqldelete="DELETE FROM accessori_auto WHERE id_auto = '$id_auto'";
$sql2 = mysqli_query($conn, $sqldelete);


//verifico gli optional inseriti
foreach ($_POST['accessori'] as $id_accessorio => $accessorio) {
	$sqlinsert="INSERT INTO accessori_auto (id_auto, id_accessori) VALUES ('$id_auto', '$id_accessorio')";
	$sql3 = mysqli_query($conn, $sqlinsert);
}


goToPage("view_auto.php?id=$id_auto&msg=6");

?>