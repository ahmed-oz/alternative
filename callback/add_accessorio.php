<?php
session_start();
include '../include/db-connect.php';

mysqli_query($conn, 'SET character_set_client = \'utf8\'');

$desc = mysqli_real_escape_string($conn, $_GET['desc']);

$query = "INSERT INTO accessori (accessorio) VALUES ('$desc');";
$result = mysqli_query($conn, $query);

?>