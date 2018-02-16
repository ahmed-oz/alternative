<?php include "include/livello3.php";?>
<?php include "include/db-connect.php";?>
<?php include "include/protezione.php";?>
<?php mysql_query("SET NAMES utf8;");?>
<?php

function normalizeFields($fld) {
	$fld = htmlspecialchars(trim($fld));
	$fld = addslashes($fld);
	return $fld;
}

$nome_concessionaria = normalizeFields($_POST['nome_concessionaria']);
$email = normalizeFields($_POST['email']);
$login = normalizeFields($_POST['login']);
$password = normalizeFields($_POST['password']);
$sito_web = normalizeFields($_POST['sito_web']);
$citta = normalizeFields($_POST['citta']);
$indirizzo = normalizeFields($_POST['indirizzo']);
$telefono = normalizeFields($_POST['telefono']);
$fax = normalizeFields($_POST['fax']);
$id_provincia = intval($_POST['id_provincia']);
$note = addslashes($_POST['note']);
$id_livello = intval($_POST['id_livello']);
$id_status = 1;

//Eseguo la query
$query = @mysql_query("SELECT login FROM concessionari WHERE login = '$login' AND id_status <> '0'");

$res_num = mysql_num_rows($query);
if ($res_num > 0)
{
	// username già presente
	goToPage("add_clienti.php?msg=1");
	die;
} else {

	$sql = "INSERT INTO `concessionari` (`tipo`, `nome_concessionaria`, `email`, `login`, `password`, `sito_web`, `citta`, `indirizzo`, `telefono`, `fax`, `id_provincia`, `note`, `id_livello`, `id_status`) VALUES (1, '$nome_concessionaria', '$email', '$login', md5('$password'), '$sito_web','$citta','$indirizzo','$telefono','$fax','$id_provincia', '$note','$id_livello','$id_status')";
	mysql_query($sql, $conn);
	
	//********************* mail
	include "include/mail.php";
	include "include/mail_template.php";
	$txt = "Complimenti ".$nome_concessionaria.", benvenuto in <a href=\"".SITE_URL_MAIL."\">Alternativa.it</a>.<br>
			<br>
			I dati del vostro account sono:<br>
			<br>
			<b>Nome e Cognome</b>: ".$nome_concessionaria."<br>
			<b>Email</b>: ".$email."<br>
			<b>Login</b>: ".$login."<br>
			<b>Password</b>: ".$password."<br>
			<b>Città</b>: ".$citta."<br>
			<b>Telefono</b>: ".$telefono."<br>
			";
	if( $fax != "" )
		$txt .= "<b>Fax</b>: ".$fax."<br>";
	$txt .= "
			<br>
			Grazie per la fiducia accordataci.<br>
			<br>
			Lo staff di <a href=\"".SITE_URL_MAIL."\">Alternativa.it</a>";
	$txt = text2mail_template($txt);
	send_mail ( $txt, "Nuovo utente altenativa.it - ".$nome_concessionaria, $email );
	//********************* fine mail

	// concessionario inserito
	goToPage("gestione_clienti.php?msg=1");
	die;

}
?>
<?php include "include/db-connect-close.php";?>