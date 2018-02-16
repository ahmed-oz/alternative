<?php
session_start();
include '../include/db-connect.php';

mysql_query('SET NAMES utf8;');

$desc = addslashes(htmlspecialchars(trim(mysql_real_escape_string($_GET['desc']))));
$id = $_GET['id'];

$query = "UPDATE `documenti_auto` SET `descrizione_documento`='$desc' WHERE `id_documento`='$id';";
$result = mysql_query($query);
?>