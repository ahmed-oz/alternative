<?php ob_start();
session_start();?>
<?php include "include/livello2.php";?>
<?php include "include/db-connect.php";?>
<?php include "include/protezione.php";?>
<?php mysql_query("SET NAMES utf8;");?>
<?php

$id_utente = $_SESSION['id_utente_sessione'];
$id_livello = $_SESSION['id_livello_sessione'];
$id_concessionari_auto = ($_GET['id_concessionari_auto']);

if ($id_concessionari_auto == 0)
    {
	//non è stata selezionata alcuna auto 
	goToPage("gestione_auto.php?msg=3");
	die;
    }
    else
    {	
	
// permette ad Alternativa di sbloccare qualsiasi auto
if ($id_livello >= 3) {
$query = @mysql_query("SELECT * FROM concessionari_auto WHERE id_concessionari_auto = '$id_concessionari_auto'");
 }else{
 // lasciamo la possibilità ai concessionari di sbloccare solo le proprie auto
$query = @mysql_query("SELECT * FROM concessionari_auto WHERE id_concessionari = '$id_utente' AND id_concessionari_auto = '$id_concessionari_auto'" );
 }

    $quanti = mysql_num_rows($query);
	
    if ($quanti <1)
    {
	goToPage("gestione_auto.php?msg=2");
	die;
    }
    else
    {
    //recupero l'id dell'auto
$row = mysql_fetch_assoc($query);
$id_auto= $row['id_auto'];

//sblocco l'auto aggiornando lo status dell'auto
$changestatus = "UPDATE auto SET id_status =2 WHERE id='$id_auto'";
$sql_changestatus = @mysql_query($changestatus);

//elimino il lock sul record dalla tabella correlata
$delete_lock = "DELETE FROM `concessionari_auto` WHERE `id_concessionari_auto`=$id_concessionari_auto;";
$sql_delete_lock = @mysql_query($delete_lock);

//********************* mail
if( $_SESSION["livello_utente"] <= 2  ) {
	$query = "SELECT * FROM auto JOIN concessionari ON auto.id_concessionario = concessionari.id_concessionaria WHERE auto.id = {$id_auto}";
	$risultati = mysql_query($query);
	$marca = mysql_result($risultati,0,"marca");
	$modello = mysql_result($risultati,0,"modello");
	$mail_proprietario = mysql_result($risultati,0,"email");
	$query = "SELECT * FROM concessionari WHERE id_concessionaria = {$_SESSION["id_utente_sessione"]}";
	$risultati=mysql_query($query);
	$mail_concessionario = mysql_result($risultati,0,"email");
	include "include/mail.php";
	include "include/mail_template.php";
	$txt = "Il concessionario <b>".ucfirst($_SESSION["nome_concessionaria_sessione"])."</b> ha sbloccato <b>".$marca." ".$modello."</b> - VU: ".$id_auto."<br>
			<br>
			Lo staff di <a href=\"".SITE_URL_MAIL."\">Alternativa.it</a>";
	$txt = text2mail_template($txt);
	$txt2concessionario = "Hai sbloccato l'auto <b>".$marca." ".$modello."</b><br>
						   <br>
						   Lo staff di <a href=\"".SITE_URL_MAIL."\">Alternativa.it</a>";
	$txt2concessionario = text2mail_template($txt2concessionario);
	if( $mail_proprietario != $mail_concessionario )
		send_mail ( $txt, "Auto sbloccata", $mail_proprietario);
	send_mail ( $txt2concessionario, "Auto sbloccata", $mail_concessionario);
	$query = "SELECT email FROM concessionari WHERE id_livello > 2";
	$risultati = mysql_query($query);
	send_mail ( $txt, "Auto sbloccata", mysql_fetch_row($risultati));
}
//********************* fine mail

goToPage("gestione_auto.php?msg=7");
die;
    }	
 }		
?>
<?php include "include/db-connect-close.php";?>