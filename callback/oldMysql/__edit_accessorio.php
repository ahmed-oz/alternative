<?php
session_start();
include '../include/db-connect.php';

mysql_query('SET NAMES utf8;');

$desc = mysql_real_escape_string($_GET['desc']);
$id = $_GET['id'];

$query = "UPDATE `accessori` SET `accessorio`='$desc' WHERE `id`='$id';";
$result = mysql_query($query);
?>