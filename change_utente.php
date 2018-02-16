<?php

/*
 ** Change PHP  MySQL Functions to PHP MySQLI Functions
 ** Aj Osman
 ** 16-02-2018
*/

include "include/db-connect.php";
include "include/functions.php";
include "include/Cookie.php";


session_start();  

if (isset($_GET['id'])) {
	$sql = "SELECT * FROM concessionari WHERE id_concessionaria = {$_GET['id']} AND id_status >=1";
	$result=mysqli_query($conn, $sql);

	// Mysql_num_row is counting table row
	$count=mysqli_num_rows($result);

	// If result matched $login and $password, table row must be 1 row
	if ($count==1) {
		while ($row = mysqli_fetch_array($result)) {
			//echo "Login SUCCESS";
			
			echo "<pre>";
			print_r($_SESSION);
			echo "</pre>";
			
			$ckie = new Cookie();
			$ckie->unsetLoginCookie('sav_user');
			
			$id_utente_sessione = $row['id_concessionaria'];
			$nome_concessionaria_sessione = $row['nome_concessionaria'];
			$id_livello_sessione = $row['id_livello'];
			$tipo_sessione = $row['tipo'];

			$_SESSION['login_utente'] = "ok"; 
			$_SESSION['id_utente_sessione'] = $id_utente_sessione;
			$_SESSION['nome_concessionaria_sessione'] = $nome_concessionaria_sessione;
			$_SESSION['id_livello_sessione'] = $id_livello_sessione;
			$_SESSION['tipo_sessione'] = $tipo_sessione;
			
			die('true');
		}
	} else {
		die('false');
	}
}
/* Aggiunto da Gianluca - 20170112 */