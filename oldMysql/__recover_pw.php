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
						$title= "Questo login non risulta corretto";
						$msg = "Riprova ad inserire il tuo login";
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
						$type= "error";
						$title= "Si è verificato un errore";
						$msg = "Riprova più tardi";
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
				<form class="mws-form" action="recover_pw_process.php" method="post">		
                    <div class="mws-form-row">
                        <div class="mws-form-item large">
                            <input type="text" name="login" class="mws-login-username required" placeholder="login" />
                        </div>
                    </div>
                    <div class="mws-form-row">
                        <input type="submit" value="Recover password" class="btn btn-success mws-login-button" />
                    </div>
                </form>
            </div>
			<p style="margin: 9.5px 0 0;"><a href="index.php"><< back</a></p>
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
