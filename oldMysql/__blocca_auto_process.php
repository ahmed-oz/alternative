<?php ob_start();
session_start();?>
<?php include "include/livello1.php";?>
<?php include "include/db-connect.php";?>
<?php include "include/protezione.php";?>
<?php

$id_utente = $_SESSION['id_utente_sessione'];
$id_auto = intval($_POST['id_auto']);
$note_blocco = ($_POST['note_blocco']);


if ($id_auto == 0)
{
	//non è stata selezionata alcuna auto 
	goToPage("gestione_auto.php?msg=3");
	die();
}
else {	
	$query = @mysql_query("SELECT * FROM concessionari_auto WHERE id_concessionari = '$id_utente' AND id_auto = '$id_auto'" );
    $quanti = mysql_num_rows($query);
	//echo $quanti."<br>";	
	
	//il concessionario ha già effettuato più di 2 blocchi dell'auto
    if ($quanti >= 2 && $_SESSION["livello_utente"] <= 2)
    {
		goToPage("gestione_auto.php?msg=2");
		die();
    }
    else {

	//inserisco la data di fine blocco + tre giorni
	$data_blocco_fine = date("Y-m-d H:i:s", mktime(date("H"),date("i"),date("s"),date("m"),date("d")+3,date("Y")));

	//blocco l'auto	 
	$insert_lock = "INSERT INTO concessionari_auto (id_concessionari, id_auto, data_blocco_fine, note_blocco) VALUES ('$id_utente', '$id_auto', '$data_blocco_fine', '$note_blocco')";
	$sql_insert_lock = @mysql_query($insert_lock);

	//aggiorno lo status dell'auto
	$changestaus = @mysql_query("UPDATE auto SET id_status =3 WHERE id='$id_auto'");

	//selezione le info sull'auto e sul concessionario per inoltrare email
	$querygetauto = mysql_query("SELECT modello, marca FROM auto WHERE id ='$id_auto'");
	$row_auto = mysql_fetch_assoc($querygetauto);
	$modello = $row_auto['modello'];
	$marca = $row_auto['marca'];

	//********************* mail
	if( $_SESSION["livello_utente"] <= 2  ) {
		$query = "SELECT * FROM auto JOIN concessionari ON auto.id_concessionario = concessionari.id_concessionaria WHERE auto.id = {$id_auto}";
		$risultati = mysql_query($query);
		$mail_proprietario = mysql_result($risultati,0,"email");
		include "include/mail.php";
		include "include/mail_template.php";
		$query = "SELECT email FROM concessionari WHERE id_livello > 2";
		$risultati=mysql_query($query);
		$txt2admin = "Complimenti, ".$_SESSION["nome_concessionaria_sessione"]." ha bloccato l'auto ".$marca." ".$modello."<br><br>"; 
		$txt2admin = text2mail_template($txt2admin);
		send_mail ( $txt2admin, "Auto bloccata - concessionario: ".$_SESSION["nome_concessionaria_sessione"], mysql_fetch_row($risultati));
		$query = "SELECT * FROM concessionari WHERE id_concessionaria = {$_SESSION["id_utente_sessione"]}";
		$risultati=mysql_query($query);
		$mail_concessionario = mysql_result($risultati,0,"email");
		if( $mail_proprietario != $mail_concessionario ){
			$txt2proprietario = "
								Complimenti il concessionario ".$_SESSION["nome_concessionaria_sessione"].", ha bloccato l'auto <b>".$marca." ".$modello."</b> - VU: ".$id_auto.".<br>
								<br>
								Ha tempo fino al giorno <b>".date("d/m/Y", strtotime($data_blocco_fine))."</b> ore <b>".date("G:i", strtotime($data_blocco_fine))."</b> per acquistarla.<br>
								<br>
								Lo staff di <a href=\"".SITE_URL_MAIL."\">Alternativa.it</a>";
			$txt2proprietario = text2mail_template($txt2proprietario);
			send_mail ( $txt2proprietario, "Auto bloccata - concessionario: ".$_SESSION["nome_concessionaria_sessione"], $mail_proprietario);
		}
		$txt2concessionario = "
								Complimenti ".$_SESSION["nome_concessionaria_sessione"].", l'auto <b>".$marca." ".$modello."</b> è stata bloccata.<br>
								<br>
								Ricordati che hai tempo fino al giorno <b>".date("d/m/Y", strtotime($data_blocco_fine))."</b> ore <b>".date("G:i", strtotime($data_blocco_fine))."</b> per acquistarla.<br>
								<br>
								Lo staff di <a href=\"".SITE_URL_MAIL."\">Alternativa.it</a>";
		$txt2concessionario = text2mail_template($txt2concessionario);
		send_mail ( $txt2concessionario, "Auto bloccata", $mail_concessionario);
	}
	//********************* fine mail
	
	goToPage("view_auto.php?id=".$id_auto."&msg=1");
	die();
	}	
}
?>
<?php include "include/db-connect-close.php";?>