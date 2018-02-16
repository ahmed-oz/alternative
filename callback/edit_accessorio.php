<?php
session_start();
include '../include/db-connect.php';

mysqli_query($conn, 'SET character_set_client = \'utf8\'');
$desc = mysqli_real_escape_string($conn, $_GET['desc']);
$id = $_GET['id'];

$query = "UPDATE `accessori` SET `accessorio`='$desc' WHERE `id`='$id';";
$result = mysqli_query($conn, $query);
?>