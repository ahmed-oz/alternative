<?php include "include/db-connect.php";


session_start();

if (isset($_POST['login']) && isset($_POST['password']) )
{
  $login = $_POST['login'];
	$password = $_POST['password'];
  $result = $pdo->prepare("SELECT * FROM users WHERE username = ? and password = ?  and id_status >=1");
  $result->bindParam(1, $username);
  $result->bindParam(2, md5($password));
  $result->execute();

  $count = $result->fetchColumn(0);

  // If result matched $login and $password, table row must be 1 row
  if($count==1)
  {
    while($row = $result->fetch(PDO::FETCH_ASSOC ))
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
