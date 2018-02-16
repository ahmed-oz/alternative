<?php

/*
 ** Change PHP  MySQL Functions to PHP MySQLI Functions
 ** Aj Osman
 ** 16-02-2018
*/

include "include/livello1.php";
include "include/db-connect.php";
include "include/protezione.php";

mysqli_query($conn, 'SET character_set_client = \'utf8\'');


$user = $_SESSION['id_utente_sessione'];

// check fields
$oldpassword = md5($_POST['oldpassword']);
$newpassword = md5($_POST['newpassword']);
$repeatnewpassword = md5 ($_POST['repeatnewpassword']);
 
$queryget = mysqli_query($conn,"SELECT password FROM concessionari WHERE id_concessionaria ='$user'") or die ("Query didnt work");
$row = mysqli_fetch_assoc($queryget);

$oldpassworddb = $row['password'];
 
//check passwords
if ($oldpassword==$oldpassworddb)
{ 
	// check two new passwords
	if ($newpassword==$repeatnewpassword)
	{ 
	//success change password in db

		$querychange = mysqli_query($conn,"UPDATE concessionari SET password='$newpassword' WHERE id_concessionaria='$user'");

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