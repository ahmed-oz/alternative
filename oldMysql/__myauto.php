<?php ob_start();
session_start(); 
?>
<?php include "include/livello2.php";?>
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

<link rel="stylesheet" type="text/css" href="css/custom.css" media="screen" />

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

                <!-- Table Start -->
<?php

$id_utente_sessione = $_SESSION['id_utente_sessione'];
/*$query="SELECT * FROM auto,concessionari_auto 
		WHERE auto.id = concessionari_auto.id_auto 
			AND (id_concessionario = '$id_utente_sessione' OR concessionari_auto.id_concessionari = '$id_utente_sessione') 
			AND auto.id_status > 0
			ORDER By id desc"; */
			$query="SELECT * FROM auto  
		            WHERE  id_concessionario = '$id_utente_sessione'
					AND auto.id_status > 0
					ORDER By id desc";
$risultati=mysql_query($query);

$num=mysql_numrows($risultati);
?>                
            	<div class="mws-panel grid_8">
                	<div class="mws-panel-header">
                    	<span><i class="icon-table"></i> Le mie auto</span>
                    </div>
					<?php  
					if (isset($_GET['msg'])) { 
						$avviso_num = $_GET['msg'];
						if ($avviso_num == 1) {
							$type= "success";
							$title= "Complimenti";
							$msg = "l'auto da te selezionata è stata correttamente bloccata";
						}
						if ($avviso_num == 2) {
							$type= "error";
							$title= "Attenzione";
							$msg = "Non è stato possibile effettuare il blocco dell'auto poichè l'hai già bloccata per due volte.";
						}
						if ($avviso_num == 3) {
							$type= "success";
							$title= "Complimenti";
							$msg = "L'auto è stata rimossa correttamente";
						}
						if ($avviso_num == 4) {
							$type= "success";
							$title= "Complimenti";
							$msg = "L'auto è stata venduta";
						}
						if ($avviso_num == 5) {
							$type= "success";
							$title= "Complimenti";
							$msg = "L'auto è stata approvata e inserita correttamente a listino";
						}
						if ($avviso_num == 6) {
							$type= "success";
							$title= "Complimenti";
							$msg = "L'auto è stata modificata correttamente";
						}
						if ($avviso_num == 99) {
							$type= "error";
							$title= "Attenzione";
							$msg = "Nessuna operazione è stata eseguita poichè c'è stato un errore";
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
                    <div class="mws-panel-body no-padding">
                        <table id="table_auto" class="mws-datatable-fn mws-table">
                            <thead>
                                <tr>
                                    <th><b>VO</b></th>
                                    <th>Inserita il</th>								
                                    <th>Marca</th>
                                    <th>Modello</th>
                                    <?php if( $_SESSION["id_livello_sessione"] > 2 ):  ?>
                                    	<th>Targa</th>
									<?php endif; ?>
                                    <th>Prezzo (commerciante)</th>
                                    <th>Status</th>
                                    <th>Tools</th>
                                </tr>
                            </thead>
                            <tbody>
							<?php
							$i=0;
							while ($i < $num) {
								$id=mysql_result($risultati,$i,"id");
								$marca=mysql_result($risultati,$i,"marca");
								$modello=mysql_result($risultati,$i,"modello");
								$targa=mysql_result($risultati,$i,"targa");
								$allestimento=mysql_result($risultati,$i,"allestimento");
								$km=mysql_result($risultati,$i,"km");
								$prezzo_operatore=mysql_result($risultati,$i,"prezzo_operatore");
								$id_status=mysql_result($risultati,$i,"id_status");
								switch ($id_status) {
									case "1":
										$status_auto = "in approvazione";
										break;
									case "2":
										$status_auto = "disponibile";
										break;
									case "3":
										$status_auto ="bloccata";
										break;
									case "4":
										$status_auto ="venduta";
										break;
								}
								$data_inserimento=mysql_result($risultati,$i,"data_inserimento");
								$data_inserimento = strtotime($data_inserimento);
								$data_it = date( 'd/m/Y', $data_inserimento );
								
								$res_foto = mysql_query("SELECT nome_foto FROM gallery_auto WHERE id_auto=$id ORDER BY id_gallery_auto LIMIT 1;");
								if(mysql_num_rows($res_foto) > 0) {
									$nome_foto = mysql_result($res_foto,0,"nome_foto");
								} else { $nome_foto = ""; }
								?>
                                <tr>
                                    <td class="col-id"><a data-href="view_auto.php?id=<?php echo $id;?>" data-img="<?php echo $nome_foto; ?>" target="_blank" class="row_link"><?php echo $id;?>
									<?php /*if ($_SESSION['id_livello_sessione'] >= 3) { ?>
										<br /><span style="font-weight:normal;"><?php echo $codice_concessionaria;?></span>
									<?php }*/ ?></a></td>
                                    <td><?=$data_it;?></td>									
                                    <td><?=$marca;?></td>
                                    <td><?=$modello;?></td>
                                    <?php if( $_SESSION["id_livello_sessione"] > 2 ):  ?>
                                    	<td><?php echo $targa;?></td>
									<?php endif; ?>
									<td><?=number_format($prezzo_operatore, 0, ',', '.');?></td>
									<td><?=$status_auto;?></td>
                                    <td class="td-btn">
										<div class="btn-group">
											<!--<a href="view_auto.php?id=<?php echo $id;?>" class="btn btn-small" alt="Apri" title="Apri"><i class="icol-application"></i></a>
											<a href="view_auto.php?id=<?php echo $id;?>" class="btn btn-small" alt="Apri in una nuova scheda" title="Apri in una nuova scheda" target="_blank"><i class="icol-application-go"></i></a>-->
											<a href="add_auto.php?id=<?php echo $id;?>" class="btn btn-small" alt="Apri" title="duplica"><i class="icol-application-double"></i></a>
											<?php if ($id_status <= 2) { 
												if( $_SESSION["id_livello_sessione"] >= 3 ||  $id_status <= 1) { ?>
													<a href="edit_auto.php?id=<?php echo $id;?>" class="btn btn-small" alt="Modifica" title="Modifica"><i class="icol-pencil"></i></a>
												<?php } elseif($_SESSION["id_livello_sessione"] >= 3 ||  $id_status <= 3) { ?>
													<a href="javascript:void(0);" onclick="conferma('<?php echo $id;?>')" class="btn btn-small" alt="Cancella" title="Cancella"><i class="icol-delete"></i></a>
												<?php }
											} ?>
										</div>
									</td>
                                </tr>
								<?php 
								$i++; 
							} 
							?>
                            </tbody>
                        </table>
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

    <!-- Plugin Scripts -->
    <script type="text/javascript" src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="plugins/colorpicker/colorpicker-min.js"></script>

    <!-- Core Script -->
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/core/mws.js"></script>

    <!-- Themer Script (Remove if not needed) -->
    <script type="text/javascript" src="js/core/themer.js"></script>
	
	<script type="text/javascript" src="./js/common.js"></script>

    <!-- Demo Scripts (remove if not needed) 
    <script type="text/javascript" src="js/demo/demo.table.js"></script>-->
	
	<script type="text/javascript">
		$(document).ready(function() {
			$('#table_auto').dataTable({
				"aaSorting": [ [2,'asc'], [3,'asc'], [0,'asc'] ],
			});
		});
	</script>
	
	<?php include "include/db-connect-close.php";?>

</body>
</html>
