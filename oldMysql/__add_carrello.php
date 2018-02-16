<?php 
ob_start();
session_start(); 

if (!isset($_SESSION['carrello_sessione'])) $_SESSION['carrello_sessione'] = [];

foreach ($_POST['auto'] as $auto) {
	if (!in_array ($auto, $_SESSION['carrello_sessione'])) {
		$_SESSION['carrello_sessione'][] = $auto;
	}
}

$carrello = count($_SESSION['carrello_sessione']);

echo json_encode(['carrello' => $carrello]);