<?php
/*
 ** Change PHP  MySQL Functions to PHP MySQLI Functions
 ** Aj Osman
 ** 16-02-2018
 ** Build a new function to replace mysql_result()
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

<style>

#table_advanced_search {
	background-color: #cccccc;
	border-bottom: 1px solid #aaaaaa;
	position: relative;
	overflow:hidden;
	display: none;
}
#table_advanced_search a {
	color: #333333;
}

#table_advanced_search .dataTables_searchForm {
	background-color: #cccccc;
	/* text-align: right; */
	padding: 8px;
	display: block;
	float: left;
}

#table_advanced_search .dataTables_searchForm#dataTables_searchError {
	/*width: 200px;*/
	color: #ff0000;
	font-size: 12px;
}

#table_advanced_search .dataTables_searchForm input.small {
	width: 60px;
}

#table_advanced_search .dataTables_searchForm input.error {
	border: solid 1px #eb979b;
}

#table_advanced_search .dataTables_searchForm label {
	display: block;
	width: auto;
}

#table_advanced_search .dataTables_submit {
	position: absolute;
	bottom: 0;
	right: 0;
}

</style>

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
            	<div class="mws-panel grid_8">
                	<div class="mws-panel-header">
                    	<span><i class="icon-table"></i> Gestionale carrello</span>
                    </div>
					<div class="mws-panel-body no-padding">
						<table class="mws-datatable-fn mws-table" id="table_auto" class="cart">
	                        <thead>
	                            <tr>
	                            	<th>VO</th>
	                                <th>Marca</th>
	                                <th>Modello</th>
	                                <th>Targa</th> <?php /* Aggiunto da Gianluca - 20170111 */ ?>
	                                <th><span title="Prezzo" alt="Prezzo">Prezzo</span></th> <?php /* Modificato da Gianluca - 20170111 */ ?>
	                                <th>Note</th>
	                                <th>Tools</th>
	                            </tr>
	                        </thead>
	                        <tbody>
							
							<?php
							if (isset($_SESSION['carrello_sessione']) && count($_SESSION['carrello_sessione']) > 0) {
								$auto = implode(", ", $_SESSION['carrello_sessione']);
								
								$query = "
									SELECT
										auto.*, alimentazione.nome_alimentazione AS nome_alimentazione, concessionari.codice_concessionaria
									FROM
										auto LEFT OUTER JOIN
										alimentazione ON auto.alimentazione = alimentazione.id LEFT OUTER JOIN
										concessionari ON auto.id_concessionario = concessionari.id_concessionaria
									WHERE
										auto.id IN ({$auto}) AND
										auto.id_status = 2 
									ORDER BY
										auto.id desc";
								
								$risultati = mysqli_query($conn, $query);
								$num = mysqli_num_rows($risultati);
								
								$i=0;
								$prezzo_totale = 0;
								while ($i < $num) {
									$id=mysqli_result($risultati,$i,"id");
									$marca=mysqli_result($risultati,$i,"marca");
									$modello=mysqli_result($risultati,$i,"modello");
									$allestimento=mysqli_result($risultati,$i,"allestimento");
									$immatricolazione=mysqli_result($risultati,$i,"immatricolazione");
									$immatricolazione = (isValidDateTime($immatricolazione . " 00:00:00") ? date("m/Y" , strtotime($immatricolazione)) : "--/----");
									$targa=mysqli_result($risultati,$i,"targa");
									$km=mysqli_result($risultati,$i,"km");
									$ubicazione=mysqli_result($risultati,$i,"ubicazione");
									$nome_alimentazione=mysqli_result($risultati,$i,"nome_alimentazione");
									$codice_concessionaria=mysqli_result($risultati,$i,"codice_concessionaria");
									$prezzo=mysqli_result($risultati,$i,"prezzo_operatore");
									
									/* Aggiunto da Gianluca - 20170111 */
									$cilindrata=mysqli_result($risultati,$i,"cc");
									$cavalli=mysqli_result($risultati,$i,"cv");
									/* Aggiunto da Gianluca - 20170111 */
									
									$prezzo_totale += $prezzo;
									
									/*
									$data_inserimento=mysql_result($risultati,$i,"data_inserimento");
									$data_inserimento = strtotime($data_inserimento);
									$data_it = date( 'd/m/Y', $data_inserimento );
									*/								
									$res_foto = mysqli_query($conn,"SELECT nome_foto FROM gallery_auto WHERE id_auto=$id ORDER BY id_gallery_auto LIMIT 1;");
									if(mysqli_num_rows($res_foto) > 0) {
										$nome_foto = mysqli_result($res_foto,0,"nome_foto");
									} else { $nome_foto = ""; }
									?>
		                            <tr class="cart">
		                            	<td class="col-id"><a data-href="view_auto.php?id=<?php echo $id;?>" data-img="<?php echo $nome_foto; ?>" target="_blank" class="row_link"><?php echo $id;?><?php  if ($_SESSION['id_livello_sessione'] >= 3) { ?><br /><span style="font-weight:normal;"><?php echo $codice_concessionaria;?></span>
										<?php } ?></a>
										</td>
		                                <td><?php echo $marca;?></td>
		                                <td><?php echo $modello . ' - ' . $allestimento . ' - ' . $cilindrata . ' ' . $nome_alimentazione . ' - ' . $cavalli . 'cv';  /* Modificato da Gianluca - 20170111 */ ?></td>
		                                <td><?php echo $targa;  /* Aggiunto da Gianluca - 20170111 */ ?></td>
		                                <td><?php echo number_format($prezzo, 0, '', '.'); /* Modificato da Gianluca - 20170111 */ ?></td>
		                                <td><input type="text" class="note_auto" id="note_<?php echo $id;?>" name="note_<?php echo $id;?>" value="" /></td>
		                                <td class="td-btn">
											<div class="btn-group">
												<a href="javascript:void(0);" onclick="confermaRimozione('<?php echo $id;?>')" class="btn btn-small" alt="Cancella" title="Cancella"><i class="icol-delete"></i></a>
											</div>
										</td>
		                            </tr>
		                            <?php 
									$i++; 
									} 
									?>
									<tr>
		                            	<td>&nbsp;</td>
		                                <td>&nbsp;</td>
		                                <td>&nbsp;</td>
		                                <td><strong>Prezzo totale</strong></td>
		                                <td><strong><?php echo number_format($prezzo_totale, 0, '', '.'); ?></strong></td>
		                                <td>&nbsp;</td>
		                                <td>
		                                	<a href="javascript:void(0);" onclick="confermaCheckout(this)" class="btn btn-small" alt="Checkout" title="Checkout"><i class="icol-accept"></i></a>
		                                </td>
		                            </tr>
									<?php
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
	
    <script type="text/javascript" src="plugins/inputmask/jquery.inputmask.js"></script>
    <script type="text/javascript" src="plugins/inputmask/jquery.inputmask.date.extensions.js"></script>

	<script type="text/javascript" src="./js/common.js"></script>
	<script type="text/javascript" src="./js/cart.js"></script>

	<!-- Demo Scripts (remove if not needed)
	<script type="text/javascript" src="js/demo/demo.table.js"></script> -->
	
	<?php include "include/db-connect-close.php";?>

</body>
</html>
