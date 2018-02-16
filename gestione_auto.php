<?php
include "include/livello1.php";
include "include/db-connect.php";
include "include/functions.php";
include "include/protezione.php";
mysqli_query($conn, 'SET character_set_client = \'utf8\'');
clear_data_blocco_fine();
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

				<?php
				$where = "";
				$prev_search_check = '0';

				if(isset($_GET['reset0'])) {
					unset($_SESSION['filter_sql']);
					unset($_SESSION['filter_vars']);
				}
				/*
				echo "<pre>";
				var_dump($_POST);
				var_dump($_SESSION);
				echo "</pre>";
				*/
				if(isset($_POST['form_name_hidden']) && $_POST['form_name_hidden'] == 1) {

					$prev_search_check = '1';

					if(isset($_POST['anno_da']))
					{
						$_SESSION['filter_vars']['anno_da'] = $_POST['anno_da'];
						if(!empty($_POST['anno_da'])) {
							$date1 = explode("/", $_POST['anno_da']);
							$where = " AND DATE_FORMAT( immatricolazione, '%Y-%m' ) >= '" . intval($date1[1]) . "-" . intval($date1[0]) . "'";
						}
					}
					if(isset($_POST['anno_a']))
					{
						$_SESSION['filter_vars']['anno_a'] = $_POST['anno_a'];
						if(!empty($_POST['anno_a'])) {
							$date2 = explode("/", $_POST['anno_a']);
							$where .= " AND DATE_FORMAT( immatricolazione, '%Y-%m' ) <= '" . intval($date2[1]) . "-" . intval($date2[0]) . "'";
						}
					}
					if(isset($_POST['km_da']))
					{
						$_SESSION['filter_vars']['km_da'] = $_POST['km_da'];
						if(!empty($_POST['km_da'])) $where .= " AND km >= '" . intval($_POST['km_da']) . "'";
					}
					if(isset($_POST['km_a']))
					{
						$_SESSION['filter_vars']['km_a'] = $_POST['km_a'];
						if(!empty($_POST['km_a'])) $where .= " AND km <= '" . intval($_POST['km_a']) . "'";
					}
					if(isset($_POST['prezzo_da']))
					{
						$_SESSION['filter_vars']['prezzo_da'] = $_POST['prezzo_da'];
						if(!empty($_POST['prezzo_da'])) $where .= " AND prezzo >= '" . intval($_POST['prezzo_da']) . "'";
					}
					if(isset($_POST['prezzo_a']))
					{
						$_SESSION['filter_vars']['prezzo_a'] = $_POST['prezzo_a'];
						if(!empty($_POST['prezzo_a'])) $where .= " AND prezzo <= '" . intval($_POST['prezzo_a']) . "'";
					}
					if(isset($_POST['alimentazione']))
					{
						$_SESSION['filter_vars']['alimentazione'] = $_POST['alimentazione'];
						if(!empty($_POST['alimentazione'])) $where .= " AND auto.alimentazione = '" . intval($_POST['alimentazione']) . "'";
					}
					if(isset($_POST['targa_telaio']))
					{
						$_SESSION['filter_vars']['targa_telaio'] = $_POST['targa_telaio'];
						if(!empty($_POST['targa_telaio'])) $where .= " AND (auto.targa LIKE '%" . mysqli_real_escape_string($conn, $_POST['targa_telaio']) . "%'" .
																	 " OR auto.telaio LIKE '%" . mysqli_real_escape_string($conn, $_POST['targa_telaio']) . "%')";
					}
					if(isset($_POST['auto_con_targa']))
					{
						$_SESSION['filter_vars']['auto_con_targa'] = true;
						$where .= " AND auto.targa != ''";
					}
					/*
					if(isset($_POST['marca']) && !empty($_POST['marca']))
					{
						$_SESSION['filter_vars']['marca'] = $_POST['marca'];
						$where .= " AND marca LIKE '%" . mysql_real_escape_string(trim($_POST['marca'])) . "%'";
					}
					if(isset($_POST['modello']) && !empty($_POST['modello']))
					{
						$_SESSION['filter_vars']['modello'] = $_POST['modello'];
						$where .= " AND modello LIKE '%" . mysql_real_escape_string($_POST['modello']) . "%'
									OR allestimento LIKE '%" . mysql_real_escape_string($_POST['modello']) . "%'";
					}
					if(isset($_POST['ubicazione']) && !empty($_POST['ubicazione']))
					{
						$_SESSION['filter_vars']['ubicazione'] = $_POST['ubicazione'];
						$where .= " AND ubicazione LIKE '%" . mysql_real_escape_string(trim($_POST['ubicazione'])) . "%'";
					}
					*/
					if(isset($_POST['ricerca_hidden']) && !empty($_POST['ricerca_hidden'])) {
						$_SESSION['filter_vars']['ricerca_hidden'] = $_POST['ricerca_hidden'];
					}
				}
				?>

				<?php
				if(isset($_SESSION['filter_sql']) && !empty($_SESSION['filter_sql']) && $where == '')
				{
					$prev_search_check = '1';
					$query = $_SESSION['filter_sql'];
				}
				else {
					$query = "SELECT auto.*, alimentazione.nome_alimentazione AS nome_alimentazione, concessionari.codice_concessionaria
							  FROM auto LEFT OUTER JOIN alimentazione ON auto.alimentazione = alimentazione.id
										LEFT OUTER JOIN concessionari ON auto.id_concessionario = concessionari.id_concessionaria
							  WHERE auto.id_status = 2 " . $where . "
							  ORDER By auto.id desc";
					if($where != '') $_SESSION['filter_sql'] = $query;
				}

				$risultati = mysqli_query($conn, $query);
				$num = mysqli_num_rows($risultati);
				?>
                <!-- Table Start -->
            	<div class="mws-panel grid_8">
            		<div class="mws-panel-header">
                    	<span><i class="icon-table"></i> Gestionale auto</span>
						<span style="float: right; margin: -25px 10px 0 0;"><a href="" class="show-adv-search-btn">˅ Ricerca avanzata</a></span>
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
						if ($avviso_num == 7) {
							$type= "success";
							$title= "Complimenti";
							$msg = "l'auto da te selezionata è stata correttamente sbloccata";
						}
						if ($avviso_num == 8) {
							$type= "warning";
							$title= "Complimenti, l'auto è stata aggiunta";
							//$msg = "Arricchisci la scheda inserendo immagini e documenti relativi all'auto cliccando qui: add_auto_files.php?id=".$_GET['id_auto'];
							$msg = "Arricchisci la scheda inserendo immagini e documenti relativi all'auto <a href='add_auto_files.php?id=".$_GET['id_auto']."'>CLICCA QUI!</a>";
						}
						if ($avviso_num == 99) {
							$type= "error";
							$title= "Attenzione";
							$msg = "Si è verificato un errore imprevisto";
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


					<form id="frm_filters" method="post" action="">
						<div id="table_advanced_search" >
							<div class="dataTables_searchForm" >
								<label>Immatricolato dal: </label>
								<input type="text" name="anno_da" class="small date" maxlength="7" value="<?php if(isset($_SESSION['filter_vars']['anno_da'])) { echo $_SESSION['filter_vars']['anno_da']; } ?>">
							</div>
							<div class="dataTables_searchForm" >
								<label>al: </label>
								<input type="text" name="anno_a" class="small date" maxlength="7" value="<?php if(isset($_SESSION['filter_vars']['anno_a'])) { echo $_SESSION['filter_vars']['anno_a']; } ?>">
							</div>

							<div class="dataTables_searchForm" >
								<label>Km da: </label>
								<input type="text" name="km_da" class="small digit" value="<?php if(isset($_SESSION['filter_vars']['km_da'])) { echo $_SESSION['filter_vars']['km_da']; } ?>">
							</div>
							<div class="dataTables_searchForm" >
								<label>a: </label>
								<input type="text" name="km_a" class="small digit" value="<?php if(isset($_SESSION['filter_vars']['km_a'])) { echo $_SESSION['filter_vars']['km_a']; } ?>">
							</div>

							<div class="dataTables_searchForm" >
								<label>Prezzo da: </label>
								<input type="text" name="prezzo_da" class="small digit" value="<?php if(isset($_SESSION['filter_vars']['prezzo_da'])) { echo $_SESSION['filter_vars']['prezzo_da']; } ?>">
							</div>
							<div class="dataTables_searchForm" >
								<label>a: </label>
								<input type="text" name="prezzo_a" class="small digit" value="<?php if(isset($_SESSION['filter_vars']['prezzo_a'])) { echo $_SESSION['filter_vars']['prezzo_a']; } ?>">
							</div>

							<div class="dataTables_searchForm" >
								<label>Alimentazione: </label>
								<?php if(isset($_SESSION['filter_vars']['alimentazione'])) { $fval = $_SESSION['filter_vars']['alimentazione']; } ?>
								<?php $result = mysqli_query($conn, "SELECT * FROM alimentazione"); ?>
								<select name="alimentazione">
									<option value=""></option>
									<?php while($row = mysqli_fetch_array($result)) { ?>
									<option value="<?php echo $row['id']; ?>" <?php if($row['id'] == $fval) echo "selected";?>><?php echo $row['nome_alimentazione']; ?></option>
									<?php } ?>
								</select>
							</div>
							<?php  if ($_SESSION['id_livello_sessione'] >= 3) { ?>
							<div class="dataTables_searchForm" >
								<label>Targa/Telaio: </label>
								<input type="text" name="targa_telaio" class="small" value="<?php if(isset($_SESSION['filter_vars']['targa_telaio'])) { echo $_SESSION['filter_vars']['targa_telaio']; } ?>">
							</div>
							<div class="dataTables_searchForm" >
								<label>Auto con targa </label>
								<input type="checkbox" name="auto_con_targa" class="small" <?php if(isset($_SESSION['filter_vars']['auto_con_targa'])) { echo "checked"; } ?>>
							</div>
							<?php } ?>
							<!--
							<div class="dataTables_searchForm" >
								<label>Marca: </label>
								<input type="text" name="marca" value="<?php if(isset($_SESSION['filter_vars']['marca'])) { echo $_SESSION['filter_vars']['marca']; } ?>">
							</div>
							<div class="dataTables_searchForm" >
								<label>Modello: </label>
								<input type="text" name="modello" value="<?php if(isset($_SESSION['filter_vars']['modello'])) { echo $_SESSION['filter_vars']['modello']; } ?>">
							</div>
							<div class="dataTables_searchForm" >
								<label>Ubicazione: </label>
								<input type="text" name="ubicazione" value="<?php if(isset($_SESSION['filter_vars']['ubicazione'])) { echo $_SESSION['filter_vars']['ubicazione']; } ?>">
							</div>-->
							<div class="dataTables_searchForm" id="dataTables_searchError"></div>
							<input type="hidden" id="ricerca_hidden" name="ricerca_hidden" value="">
							<input type="hidden" id="form_name_hidden" name="form_name_hidden" value="1">
							<div class="dataTables_searchForm dataTables_submit">
								<?php if($_SESSION['filter_sql']) { ?><a href="?reset0">Azzera filtri</a><?php } ?>
								<input type="button" value="Cerca" onclick="sendFilters();" />
							</div>
						</div>
						<table class="mws-datatable-fn mws-table" id="table_auto">
                            <thead>
                                <tr>
                                	<?php if ($_SESSION['tipo_sessione'] == 0) { ?>
                                		<th>&nbsp;</th>
                                	<?php } ?>
                                    <th><b>VO</b></th>
                                    <th>Marca</th>
                                    <th>Modello</th>
                                    <th>Targa</th> <?php /* Aggiunto da Gianluca - 20170111 */ ?>
                                    <th>Anno</th>
                                    <th>Km</th>
                                    <th>Ubicazione</th>
                                    <th><span title="Prezzo" alt="Prezzo">Prezzo</span></th> <?php /* Modificato da Gianluca - 20170111 */ ?>
                                    <th><span title="Alimentazione" alt="Alimentazione">Alim.</span></th>
                                    <th>Tools</th>
                                </tr>
                            </thead>
                            <tbody>

							<?php
							$i=0;
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
								$prezzo_operatore=mysqli_result($risultati,$i,"prezzo_operatore");

								/* Aggiunto da Gianluca - 20170111 */
								$cilindrata=mysqli_result($risultati,$i,"cc");
								$cavalli=mysqli_result($risultati,$i,"cv");
								$prezzo=mysqli_result($risultati,$i,"prezzo");
								/* Aggiunto da Gianluca - 20170111 */

								/*
								$data_inserimento=mysql_result($risultati,$i,"data_inserimento");
								$data_inserimento = strtotime($data_inserimento);
								$data_it = date( 'd/m/Y', $data_inserimento );
								*/
								$res_foto = mysqli_query($conn, "SELECT nome_foto FROM gallery_auto WHERE id_auto=$id ORDER BY id_gallery_auto LIMIT 1;");
								if(mysqli_num_rows($res_foto) > 0) {
									$nome_foto = mysqli_result($res_foto,0,"nome_foto");
								} else { $nome_foto = ""; }
								?>
                                <tr>
                                	<?php if ($_SESSION['tipo_sessione'] == 0) { ?>
                                		<td><input class="auto" type="checkbox" data-id="<?php echo $id;?>" /></td>
                                	<?php } ?>
                                    <td class="col-id"><a data-href="view_auto.php?id=<?php echo $id;?>" data-img="<?php echo $nome_foto; ?>" target="_blank" class="row_link"><?php echo $id;?><?php  if ($_SESSION['id_livello_sessione'] >= 3) { ?><br /><span style="font-weight:normal;"><?php echo $codice_concessionaria;?></span>
									<?php } ?></a>
									</td>
                                    <td><?php echo $marca;?></td>
                                    <td><?php echo $modello . ' - ' . $allestimento . ' - ' . $cilindrata . ' ' . $nome_alimentazione . ' - ' . $cavalli . 'cv';  /* Modificato da Gianluca - 20170111 */ ?></td>
                                    <td><?php echo $targa;  /* Aggiunto da Gianluca - 20170111 */ ?></td>
                                    <td><?php echo $immatricolazione; ?></td>
                                    <td><?php echo number_format($km, 0, '', '.');?></td>
                                    <td><?php echo $ubicazione;?></td>
									<td><?php echo number_format($prezzo, 0, '', '.'); /* Modificato da Gianluca - 20170111 */ ?></td>
                                    <td><?php echo $nome_alimentazione;?></td>
                                    <td class="td-btn">
										<div class="btn-group">
											<a href="#" class="btn btn-small btn-scheda" alt="Scheda" title="Scheda" data-id="<?php echo $id; ?>"><i class="icon-chevron-down"></i></a><?php /* Aggiunto da Gianluca - 20170111 */ ?>
											<!--<a href="view_auto.php?id=<?php echo $id;?>" class="btn btn-small" alt="Apri" title="Apri"><i class="icol-application"></i></a>
											<a href="view_auto.php?id=<?php echo $id;?>" class="btn btn-small" alt="Apri in una nuova scheda" title="Apri in una nuova scheda" target="_blank"><i class="icol-application-go"></i></a>-->
											<?php if ($_SESSION['id_livello_sessione'] >= 2) { ?>
	                                    	<a href="add_auto.php?id=<?php echo $id;?>" class="btn btn-small" alt="Apri" title="duplica"><i class="icol-application-double"></i></a>
											<?php } ?>
											<a href="javascript:void(0);" onclick="confBlocca('<?php echo $id;?>')" class="btn btn-small" alt="Blocca" title="Blocca"><i class="icol-lock"></i></a>
											<?php if ($_SESSION['id_livello_sessione'] >= 3) { ?>
											<a href="edit_auto.php?id=<?php echo $id;?>" class="btn btn-small" alt="Modifica" title="Modifica"><i class="icol-pencil"></i></a>
											<a href="javascript:void(0);" onclick="conferma('<?php echo $id;?>')" class="btn btn-small" alt="Cancella" title="Cancella"><i class="icol-delete"></i></a>
											<?php } ?>
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
					</form>
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

	<?php if ($_SESSION['tipo_sessione'] == 0) { ?>
		<script type="text/javascript" src="./js/cart.js"></script>
	<?php } ?>

	<!-- Demo Scripts (remove if not needed)
	<script type="text/javascript" src="js/demo/demo.table.js"></script> -->

	<script type="text/javascript">
		$(document).ready(function(){

			$("input[name='anno_da'], input[name='anno_a']").inputmask("mm/yyyy");

			$("input[name='anno_da'], input[name='anno_a']").blur(function(){
				var anno_da = $("input[name='anno_da']").val();
				var anno_a  = $("input[name='anno_a']").val();

				if( $(this).val().length != 0 && !( /(0[123456789]|10|11|12)([\/])([1-2][0-9][0-9][0-9])/.test( $(this).val() ))) {
					$("#dataTables_searchError").show().text('Inserire una data nel formato mm/yyyy').delay(3200).fadeOut(300);
					$(this).addClass('error');
				} else {
					$(this).removeClass('error');
				}

				if((anno_da.length > anno_a.length /*|| parseInt(anno_da) > parseInt(anno_a)*/) || anno_a.length != 0 ) {
					var pieces1 = anno_da.split("/");
					var pieces2 = anno_a.split("/");

					if((parseInt(pieces1[1]) > parseInt(pieces2[1])) || (parseInt(pieces1[1]) == parseInt(pieces2[1]) && parseInt(pieces1[0]) > parseInt(pieces2[0]))) {
						$("#dataTables_searchError").show().text('Il campo \'Immatricolato al\' deve essere posteriore al campo \'Immatricolato dal\'').delay(3200).fadeOut(300);
					}
				}
			});

			$("input[name='km_da'], input[name='km_a']").blur(function(){
				var km_da = $("input[name='km_da']").val();
				var km_a  = $("input[name='km_a']").val();
				if((km_da.length > km_a.length || parseInt(km_da) > parseInt(km_a)) && km_a.length != 0 ) {
					$("#dataTables_searchError").show().text('Il campo \'Km a\' deve essere maggiore del campo \'Km da\'').delay(3200).fadeOut(300);
				}
			});

			$("input[name='prezzo_da'], input[name='prezzo_a']").blur(function(){
				var prezzo_da = $("input[name='prezzo_da']").val();
				var prezzo_a  = $("input[name='prezzo_a']").val();
				if((prezzo_da.length > prezzo_a.length || parseInt(prezzo_da) > parseInt(prezzo_a)) && prezzo_a.length != 0 ) {
					$("#dataTables_searchError").show().text('Il campo \'Prezzo a\' deve essere maggiore del campo \'Prezzo da\'').delay(3200).fadeOut(300);
				}
			});

			$('#table_auto_filter input').val('<?php if(isset($_SESSION['filter_vars']['ricerca_hidden']) && $_SESSION['filter_vars']['ricerca_hidden'] != '') echo $_SESSION['filter_vars']['ricerca_hidden']; ?>');
			$('#table_auto_filter input').keyup();


			$('.show-adv-search-btn').click(function(e) {
				$('#table_advanced_search').toggle();
				e.preventDefault();
			});
			if(<?php echo $prev_search_check; ?>) {
				$('.show-adv-search-btn').trigger('click');
			}

			$('input.digit').keyup(function(e)
			{
				if (/\D/g.test(this.value))
				{
				// Filter non-digits from input value.
				this.value = this.value.replace(/\D/g, '');
				}
			});

			$('#table_auto tr').click(function() {
				var href = $(this).find("a.row_link").attr("href");console.log(href);
				if(href) {
					//window.location = href;
					window.open(href, '_blank', '');
					return false;
				}
			});

		});

		function sendFilters() {
			var ricerca = $('#table_auto_filter input').val();
			$('#ricerca_hidden').val(ricerca);
			$('#frm_filters').submit();
		}

	</script>

	<script type="text/javascript">
		$(document).ready(function() {
			$('#table_auto').dataTable({
				"aaSorting": [ [1,'asc'], [2,'asc'], [0,'asc'] ],
			});
		});
	</script>

	<?php include "include/db-connect-close.php";?>

</body>
</html>
