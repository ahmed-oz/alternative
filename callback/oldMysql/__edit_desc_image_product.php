<?php
session_start();
include '../include/db-connect.php';

mysql_query('SET NAMES utf8;');

$desc = mysql_real_escape_string($_GET['desc']);
$id = $_GET['id'];

$query = "UPDATE `gallery_auto` SET `descrizione_foto`='$desc' WHERE `id_gallery_auto`='$id';";
$result = mysql_query($query);
?>