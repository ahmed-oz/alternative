<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();

include 'Cookie.php';

$cke = new Cookie();

//se non autenticato (o il cookie non è settato)
if (!isset($_SESSION['login_utente']) && !$cke->rememberMe() )
{
	echo "<script>window.location.href='index.php?msg=2'</script>"; 
	//echo "<h3>Manca sessione utente ".$_SESSION['login_utente']."</h3>";
	die();
}

//livellopagina
if($ProtezionePagina > $_SESSION['id_livello_sessione'])
{ 
	echo "<script>window.location.href='index.php?msg=3'</script>";
	//echo "<h3>ProtezionePagina ".$ProtezionePagina."id_livello " .$_SESSION['id_livello_sessione']."</h3>";
	die();
}

//logout 
if($_GET['logout']==1) 
{
	session_start();
	session_unset();
	session_destroy();
	$_SESSION = array();
	//echo "Session DESTROYED"; debug($_SESSION, 0);
	
	if(isset($_COOKIE['sav_user'])) //se presente si distrugge il cookie di login automatico 
	{
		$cke->unsetLoginCookie('sav_user');
	}

	echo "<script>window.location.href='index.php?msg=4'</script>"; //si ricarica la pagina di login
	die();
	exit;
}
?>