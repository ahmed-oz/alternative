<?php
session_start();
include '../include/db-connect.php';

mysqli_query($conn, 'SET character_set_client = \'utf8\'');

$desc = mysqli_real_escape_string($conn, $_GET['desc']);
$id = $_GET['id'];

$query = "UPDATE `gallery_auto` SET `descrizione_foto`='$desc' WHERE `id_gallery_auto`='$id';";
$result = mysqli_query($conn, $query);
?>