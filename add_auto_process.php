<?php
/*
 ** Change PHP  MySQL Functions to PHP MySQLI Functions
 ** Aj Osman
 ** 16-02-2018
*/

ob_start();
session_start();
?>
<html>
<?php

include "include/livello2.php";
include "include/db-connect.php";
include "include/protezione.php";
include "include/functions.php";

mysqli_query($conn, 'SET character_set_client = \'utf8\'');

function normalizeFields($fld)
{
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
$kw= normalizeFields($_POST['cv'])*0.74;
$alimentazione = normalizeFields($_POST['alimentazione']);
$date_pieces = explode("/", $_POST['immatricolazione']);
$immatricolazione = normalizeFields($date_pieces[1] . "-" . $date_pieces[0] . "-01");
$colore = normalizeFields($_POST['colore']);
$ubicazione = normalizeFields($_POST['ubicazione']);
$listino = normalizeFields($_POST['listino']);
$danni = normalizeFields($_POST['danni']);
$danni_dettaglio = addslashes($_POST['danni_dettaglio']);
$prezzo = normalizeFields($_POST['prezzo']);
$prezzo_operatore = normalizeFields($_POST['prezzo_operatore']);
$note = addslashes($_POST['note']);
$telaio = normalizeFields($_POST['telaio']);
if(isset($_POST['concessionaria']) && !empty($_POST['concessionaria'])) {
	$id_concessionario = intval($_POST['concessionaria']);
} else {
	$id_concessionario = $_SESSION['id_utente_sessione'];
}

$livello_utente = $_SESSION['id_livello_sessione'];
$iva_deducibile = ( isset( $_POST['iva_deducibile'] ) ) ? 1 : 0;

//verifico se è un concessionario (in tal caso metto l'auto in approvazione) o il proprietario (auto subito visibile).
if ($livello_utente < 3) { $id_status = 1; } else { $id_status = 2; }

//eseguo la query
$sqlselect="INSERT INTO auto (targa, marca, modello, allestimento, km, cv, cc, kw, alimentazione, immatricolazione, colore, ubicazione, listino, danni, danni_dettaglio, prezzo, prezzo_operatore, note, id_status, id_concessionario, telaio, iva_deducibile) VALUES ('$targa','$marca', '$modello', '$allestimento', '$km','$cv','$cc','$kw','$alimentazione','$immatricolazione','$colore','$ubicazione','$listino','$danni','$danni_dettaglio','$prezzo','$prezzo_operatore','$note','$id_status','$id_concessionario','$telaio','$iva_deducibile')";
//echo $sqlselect; die();

$sql = mysqli_query($conn, $sqlselect);

if($sql)
{
	//recupero l'ultimo record
	$lastid= mysqli_insert_id($conn);

	//verifico gli optional inseriti
	if (isset($_POST['accessori'])) {
		foreach ($_POST['accessori'] as $id_accessorio => $accessorio) {
			$sql = mysqli_query($conn, "INSERT INTO accessori_auto (id_auto, id_accessori) VALUES ('$lastid', '$id_accessorio')");
		}	
	}
	
	//********************* mail
	if( $livello_utente <= 2  ) {
		include "include/mail.php";
		include "include/mail_template.php";
		$txt = '
				È stata caricata una nuova auto<br>	
				<br>
				Concessionario <b>'.$_SESSION["nome_concessionaria_sessione"].'</b><br>
				<br>
				<b>VU: </b> '.$lastid.'<br>
				<b>Marca:</b> '.$marca.'<br>
				<b>Modello:</b> '.$modello.'<br>
				<b>Prezzo:</b> '.$prezzo.'<br>
				<br>
				<a href="'.SITE_URL_MAIL.'/view_auto.php?id='.$lastid.'">Vedi macchina</a>  
			   ';
		$txt = text2mail_template($txt);
		$query = "SELECT * FROM concessionari WHERE id_concessionaria = {$_SESSION["id_utente_sessione"]}";
		$risultati = mysqli_query($conn, $query);
		$from_mail = mysqli_result($risultati,0,"email");
		$from_name = mysqli_result($risultati,0,"nome_concessionaria");
		$query = "SELECT email FROM concessionari WHERE id_livello > 2";
		$risultati = mysqli_query($conn, $query);
		send_mail ( $txt, "Nuova auto - Concessionario: ".$from_name, mysqli_fetch_row($risultati), $from_mail, $from_name );
	}
	//********************* fine mail

    mysqli_close($conn);
	//header("Location: gestione_auto.php?id_auto=".$lastid."&msg=8");
	goToPage("view_auto.php?id=".$lastid);
}
else {
	goToPage("gestione_auto.php?id_auto=".$lastid."&msg=99");
}
die;
?>
</html>