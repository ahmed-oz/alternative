<?php include "include/db-connect.php";?>
<?php
session_start();

include "include/Cookie.php";
$cke = new Cookie();

// se una sessione è aperta o il cookie è settato
if ( isset($_SESSION['login_utente']) || $cke->rememberMe() ) {
	goToPage("gestione_auto.php");
}
?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--><html lang="en"><!--<![endif]-->
<head>
<meta charset="utf-8" />

<!-- Viewport Metatag -->
<meta name="viewport" content="width=device-width,initial-scale=1.0" />

<!-- Required Stylesheets -->
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" media="screen" />
<link rel="stylesheet" type="text/css" href="css/fonts/ptsans/stylesheet.css" media="screen" />
<link rel="stylesheet" type="text/css" href="css/fonts/icomoon/style.css" media="screen" />

<link rel="stylesheet" type="text/css" href="css/login.css" media="screen" />

<link rel="stylesheet" type="text/css" href="css/mws-theme.css" media="screen" />

<title>Alternativa - Gestionale Auto</title>

</head>

<body>
  <p style="text-align:center;"><img border="0" src="images/alternativa-logo.png" alt="" title="" /></p>
    <div id="mws-login-wrapper">
        <div id="mws-login">
            <h1>Login</h1>
            <div class="mws-login-lock"><i class="icon-lock"></i></div>
            <div id="mws-login-form">
			<?php  
			if (isset($_GET['msg'])) { 
				$avviso_num = $_GET['msg'];
				if ($avviso_num == 1) {
					$type= "error";
					$title= "Le credenziali inserite non sono corrette";
					$msg = "Riprova ad inserire login e password";
				}
				if ($avviso_num == 2) {
					$type= "error";
					$title= "Questa pagina risulta protetta";
					$msg = "Occorre autenticarsi per visualizzare questa pagina";
				}
				if ($avviso_num == 3) {
					$type= "error";
					$title= "Questa pagina richiede maggiori privilegi";
					$msg = "Mi spiace ma non è permesso accedere a questa pagina con le tue credenziali";
				}
				if ($avviso_num == 4) {
					$type= "success";
					$title= "Logout effettuato correttamente";
					$msg = "L'operazione è andata a buon fine";
				}
				if ($avviso_num == 5) {
					$type= "success";
					$title= "La password è stata cambiata correttamente";
					$msg = "Inserisci le nuove credenziali per accedere in piattaforma";
				}
				if ($avviso_num == 6) {
					$type= "success";
					$title= "Una nuova password è stata inviata al tuo indirizzo e-mail";
					$msg = "Controlla la tua casella di posta e inserisci le nuove credenziali per accedere alla piattaforma";
				}
				?>
				<div class="mws-form-message <?php echo $type; ?>">
					<?php echo $title; ?>
					<ul>
						<li><?php echo $msg; ?></li>
					</ul>						
				</div>
			<?php
			}  
			?>
				<form class="mws-form" action="login.php" method="post">		
                    <div class="mws-form-row">
                        <div class="mws-form-item large">
                            <input type="text" name="login" class="mws-login-username required" placeholder="login" />
                        </div>
                    </div>
                    <div class="mws-form-row">
                        <div class="mws-form-item large">
                            <input type="password" name="password" class="mws-login-password required" placeholder="password" />
                        </div>
                    </div>
                    <div id="mws-login-remember" class="mws-form-row mws-inset">
                        <ul class="mws-form-list inline">
                            <li>
								<?php $cookie_name = md5("sav_user"); ?>
                                <input type="checkbox" name="remember_me" id="remember" <?php if(isset($_COOKIE[$cookie_name])) echo 'checked="checked"'; ?> /> 
                                <label for="remember">Remember me</label>
                            </li>
							<li style="float:right;vertical-align: middle;"><label><a href="recover_pw.php">Recover password</a></label></li>
                        </ul>
                    </div>
                    <div class="mws-form-row">
                        <input type="submit" value="Login" class="btn btn-success mws-login-button" />
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript Plugins -->
    <script type="text/javascript" src="js/libs/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" src="js/libs/jquery.placeholder.min.js"></script>
    <script type="text/javascript" src="custom-plugins/fileinput.js"></script>

    <!-- jQuery-UI Dependent Scripts -->
    <script type="text/javascript" src="jui/js/jquery-ui-effects.min.js"></script>

    <!-- Plugin Scripts -->
    <script type="text/javascript" src="plugins/validate/jquery.validate-min.js"></script>

    <!-- Login Script -->
    <script type="text/javascript" src="js/core/login.js"></script>

</body>
</html>
