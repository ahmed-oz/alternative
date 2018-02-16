<?php
/*
 ** Change PHP  MySQL Functions to PHP MySQLI Functions
 ** Aj Osman
 ** 16-02-2018
 ** Build a new function to replace mysql_result()
*/

include "include/livello2.php";
include "include/db-connect.php";
include "include/protezione.php";
include "include/functions.php";

mysqli_query($conn, 'SET character_set_client = \'utf8\'');

$id = intval($_GET['id']);

if($_SESSION['id_livello_sessione']<3) {
	$sql = "SELECT COUNT(*) as my_car FROM auto WHERE id = $id AND id_status = 1 AND id_concessionario = ".$_SESSION['id_utente_sessione'];
	$query = mysqli_query($conn, $sql);
	$rs = mysqli_fetch_array($query);
	if(intval($rs['my_car'])!=1) {		
		goToPage("index.php?msg=3");
		die();
	} 
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
<?php
	$query = mysqli_query($conn,"SELECT * FROM auto WHERE id = $id");

    $quanti = mysqli_num_rows($query);
    if ($quanti > 0)
    {
	
	while($row = mysqli_fetch_array($query))
	{
		$id_auto = $row['id'];
		$targa = $row['targa'];
		$marca = $row['marca'];
		$modello = $row['modello'];
		$allestimento = $row['allestimento'];
		$km = $row['km'];
		$cc = $row['cc'];
		$cv = $row['cv'];
		$kw = $row['kw'];
		$alimentazione = $row['alimentazione'];
		$immatricolazione = $row['immatricolazione'];
		$colore = $row['colore'];
		$ubicazione = $row['ubicazione'];
		$listino = $row['listino'];
		$danni = $row['danni'];
		$danni_dettaglio = $row['danni_dettaglio'];
		$prezzo = $row['prezzo'];
		$prezzo_operatore = $row['prezzo_operatore'];
		$note = $row['note'];
		$id_status = $row['id_status'];
		$id_concessionario = $row['id_concessionario'];
		$telaio = $row['telaio'];
		$iva_deducibile = ( $row['iva_deducibile'] == 1 ) ? 'checked' : ''; 
	}
    
    
?>                                
            	<div class="mws-panel grid_8">
                	<div class="mws-panel-header">
                    	<span><i class="icon-ok"></i> Modifica auto</span>
                    </div>
                    <div class="mws-panel-body no-padding">
                    	<form id="mws-validate" class="mws-form" action="edit_auto_process.php" method="post">
							<input type="hidden" name="id_auto" value="<?php echo $id_auto; ?>"/>						
                        	<div id="mws-validate-error" class="mws-form-message error" style="display:none;"></div>
                        	<div class="mws-form-inline">
								<?php  if ($_SESSION['id_livello_sessione'] >= 3) { ?>
								<div class="mws-form-cols clearfix">
                                	<div class="mws-form-col-2-8 alpha omega">
										<label class="mws-form-label">Concessionaria</label>
										<div class="mws-form-item large">
										<select name="concessionaria">
										<?php
										$sql_select = "SELECT id_concessionaria, nome_concessionaria FROM concessionari WHERE id_status >= 1 /*AND id_concessionaria != '".$_SESSION['id_utente_sessione']."'*/ ORDER BY nome_concessionaria ASC;";
										$res_select = mysqli_query($conn, $sql_select);
										while($crow = mysqli_fetch_array($res_select)) { ?>
											<option value="<?php echo $crow['id_concessionaria']; ?>" <?php if($id_concessionario == $crow['id_concessionaria']) echo "selected"; ?>><?php echo $crow['nome_concessionaria']; ?></option>
										<?php } ?>
										</select>
										</div>
									</div>
                                </div>
								<?php } ?>
								<div class="mws-form-cols clearfix">
                                	<div class="mws-form-col-2-8 alpha">
										<label class="mws-form-label">Marca</label>
										<div class="mws-form-item large">
											<input type="text" name="marca" class="required" value="<?php echo $marca; ?>"/>
										</div>
									</div>
									<div class="mws-form-col-2-8 ">
										<label class="mws-form-label">Modello</label>
											<div class="mws-form-item large">
											  <input type="text" name="modello" class="required" value="<?php echo $modello; ?>"/>
											</div>
									</div>
									<div class="mws-form-col-2-8 ">
										<label class="mws-form-label">Targa</label>
											<div class="mws-form-item large">
											  <input type="text" name="targa" value="<?php echo $targa; ?>"/>
											</div>
									</div>
									<div class="mws-form-col-2-8 omega">
										<label class="mws-form-label">Numero Telaio</label>
											<div class="mws-form-item large">
											  <input type="text" name="telaio" value="<?php echo $telaio; ?>"/>
											</div>
									</div>
                                </div>								
                            	<div class="mws-form-cols clearfix">
									<div class="mws-form-col-2-8 alpha">
										<label class="mws-form-label">Allestimento</label>
											<div class="mws-form-item large">
											  <input type="text" name="allestimento" class="required" value="<?php echo $allestimento; ?>"/>
											</div>
									</div>
									<div class="mws-form-col-2-8 ">
										<label class="mws-form-label">Colore</label>
											<div class="mws-form-item large">
											  <input type="text" name="colore" class="required" value="<?php echo $colore; ?>"/>
											</div>
									</div>
									<div class="mws-form-col-1-8 ">
										<label class="mws-form-label">Cilindrata</label>
											<div class="mws-form-item large">
											  <input type="text" name="cc" class="required" value="<?php echo $cc; ?>"/>
											</div>
									</div>
									<div class="mws-form-col-1-8 ">
										<label class="mws-form-label">Cavalli</label>
											<div class="mws-form-item large">
											  <input type="text" name="cv" class="required digits" value="<?php echo $cv; ?>"/>
											</div>
									</div>
									<div class="mws-form-col-2-8 omega">
										<label class="mws-form-label">Alimentazione</label>
										<div class="mws-form-item large">
											<select class="required" name="alimentazione">
												<option></option>
												<?php
												$res=mysqli_query($conn, "SELECT * FROM alimentazione ORDER BY nome_alimentazione");
												while ($ral = mysqli_fetch_assoc($res)) { ?>
												<option value="<?=$ral['id'];?>" <?php if($alimentazione==$ral['id']) echo "selected"; ?>><?=$ral['nome_alimentazione'];?></option>
												<?php } ?>
											</select>
										</div>
									</div>
								</div>								
                            	<div class="mws-form-cols clearfix">
									<div class="mws-form-col-2-8 alpha">
										<label class="mws-form-label">Immatricolazione</label>
										<div class="mws-form-item large">
											<input type="text" id="immatricolazione" name="immatricolazione" class="required regex" value="<?php echo date("m/Y" , strtotime($immatricolazione)); ?>"/>
										</div>
									</div>
									<div class="mws-form-col-2-8 ">
										<label class="mws-form-label">Km</label>
										<div class="mws-form-item large">
											<input type="text" name="km" class="required digits" value="<?php echo $km; ?>"/>
										</div>
									</div>
									<div class="mws-form-col-2-8 ">
										<label class="mws-form-label">Ubicazione</label>
										<div class="mws-form-item large">
											<input type="text" name="ubicazione" class="required" value="<?php echo $ubicazione; ?>"/>
										</div>
									</div>
									<div class="mws-form-col-2-8 omega">
										<label class="mws-form-label">Listino</label>
										<div class="mws-form-item large">
											<input type="text" name="listino" value="<?php echo $listino; ?>"/>
										</div>
									</div>
								</div>								
                            	<div class="mws-form-cols clearfix">
									<div class="mws-form-col-2-8 alpha">
										<label class="mws-form-label">Danni</label>
										<div class="mws-form-item large">
											<input type="text" name="danni" class="required" value="<?php echo $danni; ?>"/>
										</div>
									</div>
									<div class="mws-form-col-2-8 ">
										<label class="mws-form-label">Prezzo (privato)</label>
										<div class="mws-form-item large">
											<input type="text" name="prezzo" class="required digits" value="<?php echo $prezzo; ?>" maxlength="11" />
										</div>
									</div>
									<div class="mws-form-col-2-8 ">
										<label class="mws-form-label">Prezzo (commerciante)</label>
											<div class="mws-form-item large">
											  <input type="text" name="prezzo_operatore" class="required digits" value="<?php echo $prezzo_operatore; ?>" maxlength="11" />
											</div>
									</div>
									<div class="mws-form-col-1-8 omega">
										<label class="mws-form-label">Iva deducibile</label>
											<div class="mws-form-item" style="padding-left:30px;">
											  <input type="checkbox" name="iva_deducibile" class="" <?php echo $iva_deducibile; ?> />
											</div>
									</div>
                                </div>
                        	<div class="mws-form-row">
                            	<label class="mws-form-label">Danni (dettaglio)</label>
                                <div class="mws-form-item large">
                                	<textarea id="" name="danni_dettaglio" class="large"><?php echo $danni_dettaglio; ?></textarea>
                                </div>
                            </div>
                            <div class="mws-form-row">
                            	<label class="mws-form-label">Equipaggiamento</label>
                            	<div class="mws-form-cols"><div class="mws-form-col-8-8 "></div></div>
                            	
                            	<div class='mws-form-cols'>
	                            	<?php 
	                            	$query="SELECT * FROM accessori ORDER By accessorio";
									$risultati=mysqli_query($conn, $query);
									while($row = mysqli_fetch_array($risultati)) {
										$id_accessorio=$row["id"];
										$nome=$row["accessorio"];
	
										$query_accessori_selezionati="SELECT * FROM accessori_auto WHERE id_accessori = '$id_accessorio' AND id_auto = '$id_auto'";
										$risultati_accessori=mysqli_query($conn, $query_accessori_selezionati);
										$row_accessori = mysqli_fetch_array($risultati_accessori);
										
										$accessorio_selezionato = $row_accessori !== false ? " checked" : "";
									?>
										<div class="mws-form-col-2-8 ">
											<label class="mws-form-label" style="width: 100%;">
												<input type="checkbox" name="accessori[<?php echo $id_accessorio;?>]"<?php echo $accessorio_selezionato; ?> />
												<?php echo $nome;?>
											</label>
										</div>
									<?php
									}
									?>
								</div>
							</div>
                        	<div class="mws-form-row">
                            	<label class="mws-form-label">Note</label>
                                <div class="mws-form-item">
                                	<textarea id="cleditor" name="note"><?php echo $note; ?></textarea>
                                </div>
                            </div>
						</div>
						<div class="mws-button-row">
							<input type="submit" class="btn btn-danger" value="Modifica auto"/>
						</div>
					</div>
						
                        </form>
                    </div>    	
                </div>
                <!-- Panels End -->
				<?php
				}
				else {
					echo "<div class='mws-panel grid_8'><div class='mws-panel-header'><span><i class='icon-table'></i> Attenzione c'è stato un errore</span></div><div class='mws-form-message error'>Attenzione!<ul><li>Nessuna auto con questo valore.</li></ul></div></div>";
				}
				?>	
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
    <script type="text/javascript" src="custom-plugins/picklist/picklist.js"></script>
    <script type="text/javascript" src="plugins/select2/select2.min.js"></script>
    <script type="text/javascript" src="plugins/colorpicker/colorpicker-min.js"></script>
    <script type="text/javascript" src="plugins/validate/jquery.validate-min.js"></script>
    <script type="text/javascript" src="plugins/ibutton/jquery.ibutton.min.js"></script>
    <script type="text/javascript" src="plugins/cleditor/jquery.cleditor.min.js"></script>
    <script type="text/javascript" src="plugins/cleditor/jquery.cleditor.table.min.js"></script>
    <script type="text/javascript" src="plugins/cleditor/jquery.cleditor.xhtml.min.js"></script>
    <script type="text/javascript" src="plugins/cleditor/jquery.cleditor.icon.min.js"></script>
	
    <script type="text/javascript" src="plugins/inputmask/jquery.inputmask.js"></script>
    <script type="text/javascript" src="plugins/inputmask/jquery.inputmask.date.extensions.js"></script>
	
	<script type="text/javascript" src="./js/common.js"></script>
	
     <!-- Core Script -->
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/core/mws.js"></script>

    <!-- Themer Script (Remove if not needed) -->
    <script type="text/javascript" src="js/core/themer.js"></script>

    <!-- Demo Scripts (remove if not needed) -->
    <script type="text/javascript" src="js/demo/demo.formelements.js"></script>
	
	<script type="text/javascript">
		$(document).ready(function() {
			$("input[name='immatricolazione']").inputmask("mm/yyyy");
			
			$("#mws-validate").validate({
                rules: {
                    immatricolazione: { required: true, regex: true }
                }
            });
			
			$.validator.addMethod("regex", function(value, element) {
				return this.optional(element) || /(0[123456789]|10|11|12)([\/])([1-2][0-9][0-9][0-9])/.test(value);
			}, "Inserisci una data nel formato corretto.");
		});
	</script>
	
	<?php include "include/db-connect-close.php";?>
</body>
</html>
