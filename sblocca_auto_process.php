<?php
/*
 ** Change PHP  MySQL Functions to PHP MySQLI Functions
 ** Aj Osman
 ** 16-02-2018
*/

ob_start();
session_start();

include "include/livello2.php";
include "include/db-connect.php";
include "include/protezione.php";
include "include/functions.php";
mysqli_query($conn, 'SET character_set_client = \'utf8\'');


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
$query = mysqli_query($conn,"SELECT * FROM concessionari_auto WHERE id_concessionari_auto = '$id_concessionari_auto'");
 }else{
 // lasciamo la possibilità ai concessionari di sbloccare solo le proprie auto
$query = mysqli_query($conn,"SELECT * FROM concessionari_auto WHERE id_concessionari = '$id_utente' AND id_concessionari_auto = '$id_concessionari_auto'" );
 }

    $quanti = mysqli_num_rows($query);
	
    if ($quanti <1)
    {
	goToPage("gestione_auto.php?msg=2");
	die;
    }
    else
    {
    //recupero l'id dell'auto
$row = mysqli_fetch_assoc($query);
$id_auto= $row['id_auto'];

//sblocco l'auto aggiornando lo status dell'auto
$changestatus = "UPDATE auto SET id_status =2 WHERE id='$id_auto'";
$sql_changestatus = mysqli_query($conn, $changestatus);

//elimino il lock sul record dalla tabella correlata
$delete_lock = "DELETE FROM `concessionari_auto` WHERE `id_concessionari_auto`=$id_concessionari_auto;";
$sql_delete_lock = mysqli_query($conn, $delete_lock);

//********************* mail
if( $_SESSION["livello_utente"] <= 2  ) {
	$query = "SELECT * FROM auto JOIN concessionari ON auto.id_concessionario = concessionari.id_concessionaria WHERE auto.id = {$id_auto}";
	$risultati =  mysqli_query($conn, $query);
	$marca = mysqli_result($risultati,0,"marca");
	$modello = mysqli_result($risultati,0,"modello");
	$mail_proprietario = mysqli_result($risultati,0,"email");
	$query = "SELECT * FROM concessionari WHERE id_concessionaria = {$_SESSION["id_utente_sessione"]}";
	$risultati= mysqli_query($conn, $query);
	$mail_concessionario = mysqli_result($risultati,0,"email");
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
	$risultati = mysqli_query($conn, $query);
	send_mail ( $txt, "Auto sbloccata", mysqli_fetch_row($risultati));
}
//********************* fine mail

goToPage("gestione_auto.php?msg=7");
die;
    }	
 }		
?>
<?php include "include/db-connect-close.php";?>