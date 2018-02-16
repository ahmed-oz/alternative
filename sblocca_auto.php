<?php
/*
 ** Change PHP  MySQL Functions to PHP MySQLI Functions
 ** Aj Osman
 ** 16-02-2018
*/

ob_start();
session_start();

include "include/livello1.php";
include "include/db-connect.php";
include "include/protezione.php";

$id_utente = $_SESSION['id_utente_sessione'];
$id_auto = intval($_POST['id']);

if ($id_auto == 0) {
	//non � stata selezionata alcuna auto 
	header("Location: gestione_auto.php?msg=99");
	die();
}

$sql = "DELETE FROM concessionari_auto WHERE id_auto = ".$id_auto;
mysqli_query($conn,$sql);

//aggiorno lo status dell'auto
$changestaus = mysqli_query($conn,"UPDATE auto SET id_status = 2 WHERE id='$id_auto'");

//selezione le info sull'auto e sul concessionario per inoltrare email
$querygetauto = mysqli_query($conn,"SELECT modello, marca FROM auto WHERE id ='$id_auto'");
$row_auto = mysqli_fetch_assoc($querygetauto);
$modello = $row_auto['modello'];
$marca = $row_auto['marca'];

$queryget = mysqli_query($conn, "SELECT email, nome_concessionaria FROM concessionari WHERE id ='$id_utente'");
$row = mysqli_fetch_assoc($queryget);

$email= $row['email'];
$nome_concessionaria = $row['nome_concessionaria'];
/*
//mando email all'utente
$headers = "MIME-Version: 1.0\n".
"Content-type: text/html; charset=utf-8\n".
"From: Alternativa.it <noreply@alternativa.it>\n";
$destinatario = $email;
$oggetto = "Un auto � stata sbloccata";
$messaggio = $nome_concessionaria.", l'auto da te selezionata � stata sbloccata.<br>Ricordati che hai tempo fino a ".$data_blocco_fine." per acquistarla.<br><br>Lo staff di Alternativa.it"; 
//mail($destinatario, $oggetto, $messaggio, $headers);

//mando email all'amministratore
$headers = "MIME-Version: 1.0\n".
"Content-type: text/html; charset=utf-8\n".
"From: ".$nome_concessionaria."<".$email.">\n";
$destinatario = "d.deieso@gmail.com";
$oggetto = "Auto bloccata dal sito";
$messaggio = "Complimenti, ".$nome_concessionaria." ha bloccato l'auto ".$marca." ".$modello."<br><br>"; 
//mail($destinatario, $oggetto, $messaggio, $headers);
*/
goToPage("view_auto.php?id=".$id_auto."&msg=1");
die;
?>
