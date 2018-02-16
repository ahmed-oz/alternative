<?php ob_start();
session_start(); 
?>
<?php include "include/livello3.php";?>
<?php include "include/db-connect.php";?>
<?php include "include/protezione.php";?>
<?php mysql_query("SET NAMES utf8;");?>
<?php

$id_utente = $_SESSION['id_utente'];
$id_auto = ($_POST['id_auto']);
$id_concessionari_auto = ($_POST['id_concessionari_auto']);
$id_concessionari = ($_POST['id_concessionari']);
$note_acquisto = addslashes($_POST['note_acquisto']);

if ($id_auto == 0 || $id_concessionari_auto==0 || $id_concessionari==0)
{
	//non è stata selezionata alcuna auto 
	goToPage("gestione_auto.php?msg=3");
	die;
}
else {
	$query = @mysql_query("SELECT * FROM concessionari_auto WHERE id_concessionari_auto = '$id_concessionari_auto' " );
    $quanti = mysql_num_rows($query);
	//echo $quanti."<br>";
	
	//salvo il file
	$target = "public"; 
	$file = "VU_".$id_auto."_Conc_".$id_concessionari."_".$_FILES['conferma_ordine']['name']; 
	$file_tmp = $_FILES['conferma_ordine']['tmp_name']; 

	if (@move_uploaded_file($file_tmp , $target."/".$file))
	{
		//echo "File [$file_tmp] salvato correttamente nella directory [$target] con il nome di [$file]";
	}
	else {
		//echo "Errore nel salvataggio.<br />File TMP [$file_tmp] <br />Directory [$target]<br />Nome File [$file]";
		goToPage("gestione_auto.php?msg=99");
		die();
	}
	 
	//vendo l'auto	 
	$insert_vendita = @mysql_query("UPDATE concessionari_auto SET data_acquisto = NOW(), note_acquisto = '$note_acquisto' , conferma_ordine = '$file' WHERE id_concessionari_auto = '$id_concessionari_auto' ");

	//aggiorno lo status dell'auto
	$changestaus = @mysql_query("UPDATE auto SET id_status =4 WHERE id='$id_auto'");

	//********************* mail
	$query = "SELECT * FROM auto JOIN concessionari ON auto.id_concessionario = concessionari.id_concessionaria WHERE auto.id = {$id_auto}";
	$risultati = mysql_query($query);
	$marca = mysql_result($risultati,0,"marca");
	$modello = mysql_result($risultati,0,"modello");
	$mail_proprietario = mysql_result($risultati,0,"email");
	$nome_proprietario = mysql_result($risultati,0,"nome_concessionaria");
	include "include/mail.php";
	include "include/mail_template.php";
	$txt = "Complimenti ".$nome_proprietario.", 
			abbiamo ricevuto la conferma d'ordine per l'auto:<br>
			<br>
			<b>VU</b>: ".$id_auto."<br>
			<b>Marca</b>: ".$marca."<br>
			<b>Modello</b>: ".$modello."<br>";
	if( $note_acquisto != "" )
		$txt .= "<b>Note</b>: ".stripslashes($note_acquisto)."<br>";
	$txt .= "
			<br>
			L'auto risulta acquistata. In allegato la conferma d'ordine.<br>
			Grazie per la fiducia accordataci.<br>
			<br>
			Lo staff di <a href=\"".SITE_URL_MAIL."\">Alternativa.it</a>";
	$txt = text2mail_template($txt);
	send_mail ( $txt, "Auto Venduta - ".$marca." ".$modello, $mail_proprietario, NULL, NULL, $file, $file );
	//********************* fine mail

	goToPage("view_auto.php?id=".$id_auto."&msg=4");
	die;
}		
?>
<?php include "include/db-connect-close.php";?>