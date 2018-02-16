<?php include "include/livello1.php";?>
<?php include "include/db-connect.php";?>
<?php include "include/protezione.php";?>
<?php mysql_query("SET NAMES utf8;");?>
<?php

$user = $_SESSION['id_utente_sessione'];

// check fields
$oldpassword = md5($_POST['oldpassword']);
$newpassword = md5($_POST['newpassword']);
$repeatnewpassword = md5 ($_POST['repeatnewpassword']);
 
$queryget = mysql_query("SELECT password FROM concessionari WHERE id_concessionaria ='$user'") or die ("Query didnt work");
$row = mysql_fetch_assoc($queryget);

$oldpassworddb = $row['password'];
 
//check passwords
if ($oldpassword==$oldpassworddb)
{ 
	// check two new passwords
	if ($newpassword==$repeatnewpassword)
	{ 
	//success change password in db

		$querychange = mysql_query("UPDATE concessionari SET password='$newpassword' WHERE id_concessionaria='$user'");

		  $_SESSION=array();
		  session_destroy();
	  
	if(isset($_COOKIE['sav_user'])) //se presente si distrugge il cookie di login automatico 
		setcookie("sav_user",$cok,time()-31536000);
		goToPage("index.php?msg=5"); //si ricarica la pagina di login
		exit;
	} else {
		//echo ("New passwords don't match!");
		goToPage("change_password.php?msg=1");
		}
} else {
	//echo ("Old password doesnt match!");
	goToPage("change_password.php?msg=2");
}
?>
<?php include "include/db-connect-close.php";?>