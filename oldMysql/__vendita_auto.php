<?php include "include/livello3.php";?>
<?php include "include/db-connect.php";?>
<?php include "include/protezione.php";?>
<?php mysql_query("SET NAMES utf8;");?>
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
<link rel="stylesheet" href="plugins/elfinder/css/elfinder.css"media="screen"  />
<link rel="stylesheet" type="text/css" href="plugins/prettyphoto/css/prettyPhoto.css" media="screen" />

<!-- Required Stylesheets -->
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" media="screen" />
<link rel="stylesheet" type="text/css" href="css/fonts/ptsans/stylesheet.css" media="screen" />
<link rel="stylesheet" type="text/css" href="css/fonts/icomoon/style.css" media="screen" />

<link rel="stylesheet" type="text/css" href="css/mws-style.css" media="screen" />
<link rel="stylesheet" type="text/css" href="css/icons/icol16.css" media="screen" />
<link rel="stylesheet" type="text/css" href="css/icons/icol32.css" media="screen" />

<!-- Demo and Plugin Stylesheets -->
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
				<?php
				$id = htmlspecialchars($_GET['id']);
				$query = @mysql_query("SELECT * FROM auto, concessionari_auto WHERE concessionari_auto.id_auto = auto.id AND auto.id = $id");
				$quanti = mysql_num_rows($query);
				if ($quanti == 0)
				{
					echo "<div class='mws-panel grid_8'><div class='mws-panel-header'><span><i class='icon-table'></i>C'è stato un errore</span></div><div class='mws-form-message error'>Attenzione!<ul><li>Nessuna auto con questo valore.</li></ul></div></div>";
				}
				else {
					while($row = mysql_fetch_array($query)) 
					{
						$id_auto = $row['id'];
						$targa = $row['targa'];
						$marca = $row['marca'];
						$modello = $row['modello'];
						$allestimento = $row['allestimento'];
						$km = $row['km'];
						$immatricolazione = $row['immatricolazione'];
						$colore = $row['colore'];
						$ubicazione = $row['ubicazione'];
						$listino = $row['listino'];
						$danni = $row['danni'];
						$prezzo_operatore = $row['prezzo_operatore'];
						$note = $row['note'];
						$id_status = $row['id_status'];
						$id_concessionari = $row['id_concessionari'];		
						$id_concessionari_auto = $row['id_concessionari_auto'];		
					}
				?>
                <!-- Panels Start -->
				<div class="mws-panel grid_8">
                	<div class="mws-panel-header">
                    	<span><i class="icon-table"></i> <?php echo $marca. " " .$modello;?></span>
                    </div>
                    <div class="mws-panel-body no-padding">
                        <table class="mws-table">
                            <tbody>
                                <tr style="background-color: #C5D52B;">
                                    <td><b>VU</b></td><td><b><?php echo $id;?></b></td>
								</tr>
								<tr>
                                    <td>targa</td><td><?php echo $targa;?></td>
								</tr>
								<tr>
                                    <td>allestimento</td><td><?php echo $allestimento;?></td>
                                </tr>
								<tr>
                                    <td>km</td><td><?php echo $km;?></td>
                                </tr>
								<tr>
									<td>immatricolazione</td><td><?php echo $immatricolazione;?></td>
                                </tr> 
								<tr>
									<td>colore</td><td><?php echo $colore;?></td>
								</tr>
								<tr>
									<td>ubicazione</td><td><?php echo $ubicazione;?></td>
                                </tr>
								<tr>
									<td>listino</td><td><?php echo number_format($listino, 0, ',', '.');?></td>
                                </tr> 
								<tr>
									<td>danni</td><td><?php echo $danni;?></td>
                                </tr> 
								<tr>
									<td>prezzo (commerciante)</td><td><?php echo number_format($prezzo_operatore, 0, ',', '.');?></td>
								</tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                               
            	<div class="mws-panel grid_8">
                	<div class="mws-panel-header">
                    	<span><i class="icon-ok"></i> Conferma vendita auto</span>
                    </div>
                    <div class="mws-panel-body no-padding">
                    	<form id="mws-validate" class="mws-form" action="vendita_auto_process.php" method="post" enctype="multipart/form-data">
                        	<div id="mws-validate-error" class="mws-form-message error" style="display:none;"></div>
                        <div class="mws-form-inline">                             	
							<div class="mws-form-cols clearfix">
                                <input type="hidden" value="<?php echo $id;?>" name="id_auto" />
								<input type="hidden" value="<?php echo $id_concessionari;?>" name="id_concessionari" />
								<input type="hidden" value="<?php echo $id_concessionari_auto;?>" name="id_concessionari_auto" />
								<div class="mws-form-row">
									<label class="mws-form-label">Note</label>
									<div class="mws-form-item">
										<textarea id="cleditor" name="note_acquisto"></textarea>
									</div>
								</div>
								<div class="mws-form-cols clearfix">
										<div class="mws-form-col-8-8 alpha">
										<label class="mws-form-label">Allega conferma ordine</label>
										<div class="mws-form-item large">
											<input type="file" name="conferma_ordine" class="required" />
											<label for="picture" class="error" generated="true" style="display:none"></label>
										</div>
										</div>
								</div>
							</div>
                            <div class="mws-button-row">
                            	<input type="submit" class="btn btn-danger" value="Conferma Vendita Auto"/>
                            </div>
						</div>
						
                        </form>
                    </div>   
                <!-- Panels End -->
				</div>
			<?php } ?>
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
    <script type="text/javascript" src="jui/js/timepicker/jquery-ui-timepicker.min.js"></script>
    <script type="text/javascript" src="jui/js/jquery.ui.touch-punch.js"></script>

    <!-- Plugin Scripts -->
    <script type="text/javascript" src="plugins/colorpicker/colorpicker-min.js"></script>
    <script type="text/javascript" src="plugins/elfinder/js/elfinder.min.js"></script>
    <script type="text/javascript" src="plugins/validate/jquery.validate-min.js"></script>
	
	<script type="text/javascript" src="./js/common.js"></script>

    <!-- Core Script -->
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/core/mws.js"></script>

    <script type="text/javascript" src="js/demo/demo.formelements.js"></script>

	<?php include "include/db-connect-close.php";?>

</body>
</html>
