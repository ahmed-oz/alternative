<?php
/*
 ** Change PHP  MySQL Functions to PHP MySQLI Functions
 ** Aj Osman
 ** 16-02-2018
 ** Build a new function to replace mysql_result()
*/

include "include/db-connect.php";
include "include/functions.php";

mysqli_query($conn, 'SET character_set_client = \'utf8\'');

session_start();  

if (isset($_POST['login']) ) 
{ 
	$login = mysqli_real_escape_string($conn, $_POST['login']);

	$sql = "SELECT email FROM concessionari WHERE login = '$login' AND id_status >=1";
	$result = mysqli_query($conn, $sql);

	// Mysql_num_row is counting table row
	$count = mysqli_num_rows($result);

	// If result matched $login, table row must be 1 row
	if($count==1)
	{
		while($row = mysqli_fetch_array($conn, $result))
		{
			$email = $row['email'];
			
			// genera nuova password
			$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
			$count_chars = mb_strlen($chars);
			
			for($i = 0, $new_password = ''; $i < 8; $i++) {
				$index = rand(0, $count_chars - 1);
				$new_password .= mb_substr($chars, $index, 1);
			}
			
			$res = mysqli_query($conn,"UPDATE concessionari SET password = md5('" . $new_password . "') WHERE email = '" . $email . "'");
			if($res) {

				// invio mail
				include "include/mail.php";
				include "include/mail_template.php";
				
				$txt = "A seguito della tua richiesta, è stata generata una nuova password.<br /><br />
						Password: <b>$new_password</b><br /><br />
						Una volta effettuato l'accesso, potrai modificare la password con una di tuo piacimento.
						<br /><br /><br />
						Lo staff di <a href=\"".SITE_URL_MAIL."\">Alternativa.it</a>";
				$txt = text2mail_template($txt);
				
				send_mail( $txt, "Alternativa.it - recupero password", $email, NULL, "Alternativa.it");
				goToPage("index.php?msg=6");
				die;

			} else {
				goToPage("recover_pw.php?msg=6");
				die;
			}
		}
	}
	else {
		goToPage("recover_pw.php?msg=1");
		die;
	}
}
?>
<?php include "include/db-connect-close.php";?>