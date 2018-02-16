<?php include "include/db-connect.php";?>
<?php

?>
<?php  
session_start();  

    if (isset($_POST['login']) && isset($_POST['password']) ) 
	{ 

		$login = mysql_real_escape_string($_POST['login']);
		$password = mysql_real_escape_string($_POST['password']);

			$sql = "SELECT * FROM concessionari WHERE login = '$login' AND password = md5('$password') AND id_status >=1";
			$result=mysql_query($sql);

				// Mysql_num_row is counting table row
				$count=mysql_num_rows($result);

				// If result matched $login and $password, table row must be 1 row

				if($count==1)
				
					{

					while($row = mysql_fetch_array($result)) 
							{

					$id_utente = $row['id'];
					$nome_concessionaria = $row['nome_concessionaria'];
					$id_livello = $row['id_livello'];

					$_SESSION['login_utente'] = "ok"; 
					$_SESSION['id_utente'] = $id_utente;
					$_SESSION['nome_concessionaria'] = $nome_concessionaria;
					$_SESSION['id_livello'] = $id_livello;

					goToPage("gestione_auto.php");
					die;
							}
					} else {
					goToPage("index.php?msg=1");
					die;
					}
	
	} 
?>
<?php include "include/db-connect-close.php";?>