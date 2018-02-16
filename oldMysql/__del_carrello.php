<?php 
ob_start();
session_start(); 

if (!isset($_SESSION['carrello_sessione'])) $_SESSION['carrello_sessione'] = [];

foreach ($_SESSION['carrello_sessione'] as $key => $auto) {
	if ($auto == $_POST['auto']) {
		unset($_SESSION['carrello_sessione'][$key]);
	}
}