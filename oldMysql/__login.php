<?php include "include/db-connect.php";?>
<?php include "include/Cookie.php";?>
<?php 
session_start();  

if ( isset($_POST['login']) && isset($_POST['password']) ) 
{
	$login    = mysql_real_escape_string($_POST['login']);
	$password = mysql_real_escape_string($_POST['password']);
	$remember = (isset($_POST['remember_me'])) ? 1 : 0;
	
	$sql = "SELECT * FROM concessionari WHERE login = '$login' AND password = md5('$password') AND id_status >=1";
	$result=mysql_query($sql);

	// Mysql_num_row is counting table row
	$count=mysql_num_rows($result);

	// If result matched $login and $password, table row must be 1 row
	if($count==1)
	{
		while($row = mysql_fetch_array($result)) 
		{
			//echo "Login SUCCESS";
			
			$ckie = new Cookie();
			$ckie->unsetLoginCookie('sav_user');
			
			$id_utente_sessione = $row['id_concessionaria'];
			$nome_concessionaria_sessione = $row['nome_concessionaria'];
			$id_livello_sessione = $row['id_livello'];
			$tipo_sessione = $row['tipo']; /* Aggiunto da Gianluca - 20170116 */

			$_SESSION['login_utente'] = "ok"; 
			$_SESSION['id_utente_sessione'] = $id_utente_sessione;
			$_SESSION['nome_concessionaria_sessione'] = $nome_concessionaria_sessione;
			$_SESSION['id_livello_sessione'] = $id_livello_sessione;
			$_SESSION['tipo_sessione'] = $tipo_sessione; /* Aggiunto da Gianluca - 20170116 */
			
			/* Modificato da Gianluca - 20170112 */
			// Se amministratore, memorizza l'utente di partenza
			if ($id_livello_sessione >= 98) { $_SESSION['id_amministratore_sessione'] = $id_utente_sessione; }
			/* Modificato da Gianluca - 20170112 */
					
			if($remember) {
				$ckie->setLoginCookie($row['login']);
			}
			clear_data_blocco_fine();
			
			goToPage("gestione_auto.php");
			die;
		}
	} else {
		//echo "Login FAIL";
		goToPage("index.php?msg=1");
		die;
	}
}

?>
<?php include "include/db-connect-close.php";?>