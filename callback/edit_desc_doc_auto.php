<?php
session_start();
include '../include/db-connect.php';

mysqli_query($conn, 'SET character_set_client = \'utf8\'');

$desc = addslashes(htmlspecialchars(trim(mysqli_real_escape_string($conn, $_GET['desc']))));
$id = $_GET['id'];

$query = "UPDATE `documenti_auto` SET `descrizione_documento`='$desc' WHERE `id_documento`='$id';";
$result = mysqli_query($conn, $query);
?>