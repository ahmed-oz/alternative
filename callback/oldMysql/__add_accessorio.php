<?php
session_start();
include '../include/db-connect.php';

mysql_query('SET NAMES utf8;');

$desc = mysql_real_escape_string($_GET['desc']);

$query = "INSERT INTO accessori (accessorio) VALUES ('$desc');";
$result = mysql_query($query);
?>