<?php
/*
 ** Change PHP  MySQL Functions to PHP MySQLI Functions
 ** Aj Osman
 ** 16-02-2018
*/

include "include/livello1.php";
include "include/db-connect.php";
include "include/protezione.php";
include "include/functions.php";

mysqli_query($conn, 'SET character_set_client = \'utf8\'');

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

<!-- Plugin Stylesheets first to ease overrides -->
<link rel="stylesheet" type="text/css" href="plugins/colorpicker/colorpicker.css" media="screen" />
<link rel="stylesheet" type="text/css" href="custom-plugins/picklist/picklist.css" media="screen" />
<link rel="stylesheet" type="text/css" href="plugins/select2/select2.css" media="screen" />
<link rel="stylesheet" type="text/css" href="plugins/ibutton/jquery.ibutton.css" media="screen" />
<link rel="stylesheet" type="text/css" href="plugins/cleditor/jquery.cleditor.css" media="screen" />

<!-- Required Stylesheets -->
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" media="screen" />
<link rel="stylesheet" type="text/css" href="css/fonts/ptsans/stylesheet.css" media="screen" />
<link rel="stylesheet" type="text/css" href="css/fonts/icomoon/style.css" media="screen" />

<link rel="stylesheet" type="text/css" href="css/mws-style.css" media="screen" />
<link rel="stylesheet" type="text/css" href="css/icons/icol16.css" media="screen" />
<link rel="stylesheet" type="text/css" href="css/icons/icol32.css" media="screen" />

<!-- Demo Stylesheet -->
<link rel="stylesheet" type="text/css" href="css/demo.css" media="screen" />

<!-- jQuery-UI Stylesheet -->
<link rel="stylesheet" type="text/css" href="jui/css/jquery.ui.all.css" media="screen" />
<link rel="stylesheet" type="text/css" href="jui/jquery-ui.custom.css" media="screen" />

<!-- Theme Stylesheet -->
<link rel="stylesheet" type="text/css" href="css/mws-theme.css" media="screen" />
<link rel="stylesheet" type="text/css" href="css/themer.css" media="screen" />

<title>Alternativa - Gestionale Auto</title>

</head>

<body>
	<!-- Header -->
	<?php include "include/header.php";?>
	<!-- end header --> 

 
    <!-- Start Main Wrapper -->
    <div id="mws-wrapper">
    
    	<!-- Necessary markup, do not remove -->
		<div id="mws-sidebar-stitch"></div>
		<div id="mws-sidebar-bg"></div>
        
        <!-- Sidebar Wrapper -->
        <div id="mws-sidebar">
        
            <!-- Hidden Nav Collapse Button -->
            <div id="mws-nav-collapse">
                <span></span>
                <span></span>
                <span></span>
            </div>
			
            <!-- Main Navigation -->
			<?php include "include/navigation.php";?>			
			<!-- end navigation menu -->
        </div>
        
        <!-- Main Container Start -->
        <div id="mws-container" class="clearfix">
        
        	<!-- Inner Container Start -->
            <div class="container">
            
            	<!-- Statistics Button Container -->
				<?php include "include/stat.php";?>	               	
				<!-- End Statistics Button Container -->
               
                <!-- Table concessionari Start -->
                               
            	<div class="mws-panel grid_8">
                	<div class="mws-panel-header">
                    	<span><i class="icon-ok"></i> Profilo utente</span>
                    </div>
                    <div class="mws-panel-body">
                        	<div id="mws-validate-error" class="mws-form-message error" style="display:none;"></div>
							<?php  
							    if (isset($_GET['msg'])) { 
								$avviso_num = $_GET['msg'];
								if ($avviso_num == 1) {
									$type= "error";
									$title= "Msg 1";
									$msg = "Profilo non autorizzato";
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
								<?php
								$id_concessionaria = intval($_SESSION['id_utente_sessione']);
								$sql = "SELECT * FROM concessionari WHERE id_concessionaria = $id_concessionaria";
								$query = mysqli_query($conn, $sql);
								$res_num = mysqli_num_rows($query);
								if ($res_num > 0){
									$row = mysqli_fetch_array($query); 
									$nome_concessionaria = $row['nome_concessionaria'];
									$email = $row['email'];
									$login = $row['login'];
									$sito_web = $row['sito_web'];
									$indirizzo = $row['indirizzo'];
									$citta = $row['citta'];
									$telefono = $row['telefono'];
									$fax = $row['fax'];
									$nome_province_selezionata = $row['nome_province'];
									$id_provincia_selezionata = $row['id_provincia'];
									$note = $row['note'];
									$id_livello = $row['id_livello'];
									$id_status = $row['id_status'];
								}
								else {
									goToPage("view_profile.php?msg=1");
									die;
								}
								?>
								<b>Utente:</b> <?php echo $login; ?><br>
								<b>Mail:</b> <?php echo $email; ?><br>
								<b>Nome concessionara:</b> <?php echo $nome_concessionaria; ?><br>
								<b>Status concessionaria:</b> <?php ( $id_status == 1 ) ? $p = "Concessionaria attiva" : $p = "Concessionaria non attiva"; echo $p; ?><br>
								<?php 
								switch ($id_livello) {
									case 1: $p = "Utente standard";  break;
									case 2: $p = "Inserzionista"; break;
									case 98: $p = "Admin"; break;
									case 99: $p = "Super admin"; break;
								}
								?>
								<b>Livello utente:</b> <?php echo $p; ?>
						</div>
                    </div>    	
                </div>
                
                <!-- Panels End -->
            </div>
            <!-- Inner Container End -->
                       
            <!-- Footer -->
            <div id="mws-footer">
            	<?php include "include/footer.php";?>
            </div>
            
        </div>
        <!-- Main Container End -->
        
    </div>

    <!-- JavaScript Plugins -->
    <script type="text/javascript" src="js/libs/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" src="js/libs/jquery.mousewheel.min.js"></script>
    <script type="text/javascript" src="js/libs/jquery.placeholder.min.js"></script>
    <script type="text/javascript" src="custom-plugins/fileinput.js"></script>

    <!-- jQuery-UI Dependent Scripts -->
    <script type="text/javascript" src="jui/js/jquery-ui-1.9.0.min.js"></script>
    <script type="text/javascript" src="jui/jquery-ui.custom.min.js"></script>
    <script type="text/javascript" src="jui/js/jquery.ui.touch-punch.js"></script>

    <script type="text/javascript" src="jui/js/globalize/globalize.js"></script>
    <script type="text/javascript" src="jui/js/globalize/cultures/globalize.culture.en-US.js"></script>

    <!-- Plugin Scripts -->
    <script type="text/javascript" src="custom-plugins/picklist/picklist.min.js"></script>
    <script type="text/javascript" src="plugins/select2/select2.min.js"></script>
    <script type="text/javascript" src="plugins/colorpicker/colorpicker-min.js"></script>
    <script type="text/javascript" src="plugins/validate/jquery.validate-min.js"></script>
    <script type="text/javascript" src="plugins/ibutton/jquery.ibutton.min.js"></script>
    <script type="text/javascript" src="plugins/cleditor/jquery.cleditor.min.js"></script>
    <script type="text/javascript" src="plugins/cleditor/jquery.cleditor.table.min.js"></script>
    <script type="text/javascript" src="plugins/cleditor/jquery.cleditor.xhtml.min.js"></script>
    <script type="text/javascript" src="plugins/cleditor/jquery.cleditor.icon.min.js"></script>

	<script type="text/javascript" src="./js/common.js"></script>

    <!-- Core Script -->
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/core/mws.js"></script>

    <!-- Themer Script (Remove if not needed) -->
    <script type="text/javascript" src="js/core/themer.js"></script>

    <!-- Demo Scripts (remove if not needed) -->
    <script type="text/javascript" src="js/demo/demo.formelements.js"></script>
	
	<?php include "include/analitycs.php"; ?>
	<?php include "include/db-connect-close.php";?>

</body>
</html>
