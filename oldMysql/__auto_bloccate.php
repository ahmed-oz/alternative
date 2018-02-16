<?php include "include/livello2.php";?>
<?php include "include/db-connect.php";?>
<?php include "include/protezione.php";?>
<?php mysql_query("SET NAMES utf8;");?>
<?php clear_data_blocco_fine(); ?>
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
					if( $_SESSION['id_livello_sessione'] >= 3 ){
						$query="SELECT * FROM auto, concessionari_auto, concessionari WHERE concessionari_auto.id_auto = auto.id AND concessionari.id_concessionaria = concessionari_auto.id_concessionari AND auto.id_status = 3 ORDER By id desc";
					}
					else {
						$query="SELECT * FROM auto, concessionari_auto, concessionari WHERE concessionari_auto.id_auto = auto.id AND concessionari.id_concessionaria = concessionari_auto.id_concessionari AND auto.id_status = 3 AND  concessionari_auto.id_concessionari = {$_SESSION['id_utente_sessione']} ORDER By id desc";
					}
					$risultati=mysql_query($query);
					$num=mysql_numrows($risultati);
					?>                
					<div class="mws-panel grid_8">
						<div class="mws-panel-header">
							<span><i class="icon-table"></i> Visualizzazione auto bloccate da concessionarie</span>
						</div>
						<?php  
					if (isset($_GET['msg'])) { 
						$avviso_num = $_GET['msg'];
						if ($avviso_num == 1) {
							$type= "success";
							$title= "Complimenti";
							$msg = "l'auto da te selezionata è stata correttamente bloccata";
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
                                	<th>&nbsp;</th>
                                    <th><b>VO</b></th>
                                    <th>Data blocco</th>
                                    <th>Marca</th>
                                    <th>Modello</th>
                                    <?php if( $_SESSION["id_livello_sessione"] > 2 ):  ?>
                                    	<th>Targa</th>
									<?php endif; ?>
                                    <th>Concessionaria / Cliente</th>
                                    <th>Tools</th>
                                </tr>
                            </thead>
                            <tbody>
							<?php
							$i=0;
							while ($i < $num)
							{
								$id=mysql_result($risultati,$i,"id");
								$targa=mysql_result($risultati,$i,"targa");
								$marca=mysql_result($risultati,$i,"marca");
								$modello=mysql_result($risultati,$i,"modello");
								$nome_concessionaria=mysql_result($risultati,$i,"nome_concessionaria");
								$codice_concessionaria=mysql_result($risultati,$i,"codice_concessionaria");
								$id_concessionari_auto=mysql_result($risultati,$i,"id_concessionari_auto");
								$data_blocco_inizio=mysql_result($risultati,$i,"data_blocco_inizio");
								$data_blocco_inizio = strtotime($data_blocco_inizio);
								$data_blocco_inizio_it = date( 'd/m/Y H:i', $data_blocco_inizio);
								
								$res_foto = mysql_query("SELECT nome_foto FROM gallery_auto WHERE id_auto=$id ORDER BY id_gallery_auto LIMIT 1;");
								if(mysql_num_rows($res_foto) > 0) {
									$nome_foto = mysql_result($res_foto,0,"nome_foto");
								} else { $nome_foto = ""; }
								?>
                                <tr>
                                	<td><input class="auto" type="checkbox" data-id="<?php echo $id_concessionari_auto;?>" /></td>
                                    <td class="col-id"><a data-href="view_auto.php?id=<?php echo $id;?>" data-img="<?php echo $nome_foto; ?>" target="_blank" class="row_link"><?php echo $id;?>
									<?php  if ($_SESSION['id_livello_sessione'] >= 3) { ?>
										<br /><span style="font-weight:normal;"><?php echo $codice_concessionaria;?></span>
									<?php } ?></a>
									</td>
                                    <td><?php echo $data_blocco_inizio_it;?></td>									
                                    <td><?php echo $marca;?></td>
									<td><?php echo $modello;?></td>
									<?php if( $_SESSION["id_livello_sessione"] > 2 ):  ?>
                                    	<td><?php echo $targa;?></td>
									<?php endif; ?>
									<td><?php echo $nome_concessionaria;?></td>
                                    <td class="td-btn">
									<div class="btn-group">
										<a href="sblocca_auto_process.php?id_concessionari_auto=<?php echo $id_concessionari_auto;?>" class="btn btn-small"><i class="icol-lock-unlock"></i> Sblocca</a>
										<?php if($_SESSION['id_livello_sessione'] >= 3 || ($id_status == 1 && $_SESSION['id_livello_sessione'] == 2)) { ?>
										<a href="vendita_auto.php?id=<?php echo $id;?>" class="btn btn-small"><i class="icol-money-euro"></i> Venduta</a>
										<?php } ?>
										<!--<a href="view_auto.php?id=<?php echo $id;?>" class="btn btn-small" title="Apti" alt="apri"><i class="icol-application-view-xp"></i> Apri</a>-->
										<a href="view_auto.php?id=<?php echo $id;?>" class="btn btn-small" title="Apri in una nuova scheda" alt="Apri in una nuova scheda" target="_blank"><i class="icol-application-go"></i> Apri</a>
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
	
	<script type="text/javascript" src="./js/block.js"></script>

    <!-- Demo Scripts (remove if not needed) 
    <script type="text/javascript" src="js/demo/demo.table.js"></script>-->
	
	<?php include "include/db-connect-close.php";?>
	
	<script type="text/javascript">
		$(document).ready(function() {
			$('#table_auto').dataTable({
				"aaSorting": [ [2,'asc'], [3,'asc'], [0,'asc'] ],
			});
		});
	</script>
	
</body>
</html>
