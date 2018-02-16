<?php
/*
 ** Change PHP  MySQL Functions to PHP MySQLI Functions
 ** Aj Osman
 ** 16-02-2018
 ** Build a new function to replace mysql_result()
*/

include "include/livello3.php";
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
                <?php

                $id_concessionaria = mysqli_real_escape_string($conn, $_GET['id']);

                $query = mysqli_query($conn,"SELECT * FROM concessionari, province WHERE concessionari.id_provincia = province.id_province AND concessionari.id_concessionaria = $id_concessionaria");
                $quanti = mysqli_num_rows($query);
                if ($quanti == 0)
                {
                    $error = "<div class='mws-form-message error'>Attenzione!<ul><li>Nessun concessionario con questo valore.</li></ul></div>";
                }
                else {
                    while($row = mysqli_fetch_array($query))
                    {
                        $nome_concessionaria = $row['nome_concessionaria'];
                        $codice_concessionaria = $row['codice_concessionaria'];
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
                        $ccia_pdf = $row['ccia'];
                    }
                }
            ?>
				<?php // var_dump($_SESSION['id_utente_sessione']); var_dump($_SESSION['id_livello_sessione']);?>
            	<div class="mws-panel grid_8">
                	<div class="mws-panel-header">
                    	<span><i class="icon-ok"></i> Modifica concessionaria</span>
                    </div>
                    <div class="mws-panel-body no-padding">
                    	<form id="mws-validate" class="mws-form" action="edit_concessionari_process.php" method="post" enctype="multipart/form-data">
                        	<input type="hidden" name="id_concessionaria" value="<?php echo $id_concessionaria; ?>"/>
                        	<div id="mws-validate-error" class="mws-form-message error" style="display:none;"></div>
                        	<div class="mws-form-inline">           
								<div class="mws-form-cols clearfix">
                                	<div class="mws-form-col-2-8 alpha">
										<label class="mws-form-label">Codice</label>
										<div class="mws-form-item large">
											<input type="text" name="codice_concessionaria" class="required" value="<?php echo $codice_concessionaria; ?>" maxlength="5" />
										</div>
									</div>
								</div>							
								<div class="mws-form-cols clearfix">
                                	<div class="mws-form-col-4-8 alpha">
										<label class="mws-form-label">Ragione sociale</label>
											<div class="mws-form-item large">
											  <input type="text" name="nome_concessionaria" class="required" value="<?php echo $nome_concessionaria; ?>"/>
											</div>
									</div>
									<div class="mws-form-col-4-8 alpha">
										<label class="mws-form-label">Login</label>
											<div class="mws-form-item large">
											  <input type="text" name="login" class="required" disabled value="<?php echo $login; ?>"/>
											</div>
									</div>
								</div>
								
								<div class="mws-form-cols clearfix">
                                	<div class="mws-form-col-4-8 alpha">
										<label class="mws-form-label">Indirizzo</label>
											<div class="mws-form-item large">
											  <input type="text" name="indirizzo" class="required" value="<?php echo $indirizzo; ?>"/>
											</div>
									</div>
									<div class="mws-form-col-2-8 alpha">
										<label class="mws-form-label">Città</label>
											<div class="mws-form-item large">
											  <input type="text" name="citta" class="required" value="<?php echo $citta; ?>"/>
											</div>
									</div>
									<div class="mws-form-col-2-8 alpha">
										<label class="mws-form-label">Provincia</label>
											<div class="mws-form-item large">
											<select class="required" name="id_provincia">
                                        	<option value="<?php echo $id_provincia_selezionata; ?>"><?php echo $nome_province_selezionata; ?></option>
                                                <?php
                                                $query="SELECT * FROM province ORDER By nome_province";
                                                $risultati=mysqli_query($conn, $query);
                                                $num= mysqli_num_rows($risultati);
                                                while ($i < $num) {
                                                $id_province= mysqli_result($risultati,$i,"id_province");
                                                $nome_province= mysqli_result($risultati,$i,"nome_province");
                                                ?>
                    						<option value="<?php echo $id_province;?>"><?php echo $nome_province;?></option>
                                                <?php $i++; } ?>
											</select>
											</div>
									</div>
								</div>
								<div class="mws-form-cols clearfix">
                                	<div class="mws-form-col-3-8 alpha">
                                	<label class="mws-form-label">Email</label>
                                	<div class="mws-form-item large">
                                    	<input type="text" name="email" class="required email" value="<?php echo $email; ?>"/>
                                    </div>
									</div>
									<div class="mws-form-col-3-8 alpha">
										<label class="mws-form-label">Sito web</label>
										<div class="mws-form-item large">
											<input type="text" name="sito_web" class="url" value="<?php echo $sito_web; ?>"/>
										</div>
									</div>
									<div class="mws-form-col-2-8 alpha">
                                	<label class="mws-form-label">Livello</label>
                                	<div class="mws-form-item large">
                    					<select class="required" name="id_livello">
                                        	<!-- <option value="<?php echo $id_livello; ?>"><?php echo $id_livello; ?></option> -->
                    						<option value="1" <?php ($id_livello == 1) ? $p = 'selected' : $p = ''; echo $p; ?> >Utente standard</option>
                    						<option value="2" <?php ($id_livello == 2) ? $p = 'selected' : $p = ''; echo $p; ?> >Inserzionista</option>
                    						<option value="98" <?php ($id_livello == 98) ? $p = 'selected' : $p = ''; echo $p; ?> >Admin</option>
                    						<option value="99" <?php ($id_livello == 99) ? $p = 'selected' : $p = ''; echo $p; ?> >Super Admin</option>
                    					</select>
                                    </div>
									</div>
								</div>
								
								<div class="mws-form-cols clearfix">
                                	<div class="mws-form-col-4-8 alpha">
                                	<label class="mws-form-label">Telefono</label>
                                	<div class="mws-form-item large">
                                    	<input type="text" name="telefono" class="required" value="<?php echo $telefono; ?>"/>
                                    </div>
									</div>
									<div class="mws-form-col-4-8 alpha">
										<label class="mws-form-label">Fax</label>
										<div class="mws-form-item large">
											<input type="text" name="fax" value="<?php echo $fax; ?>"/>
										</div>
									</div>
								</div>
                                <div class="mws-form-cols clearfix">
                                    <div class="mws-form-col-4-8 alpha">                                
                                    <label class="mws-form-label">Ccia caricato:</label><br /><br />
                                    <?php if ( $ccia_pdf != '0' ): ?>
                                    <a href="./public/<?php echo $ccia_pdf; ?>" target="_blank">Download pdf: <?php echo $ccia_pdf; ?></a>
                                    <?php else: ?>
                                    <p>Pdf CCIA non presente</p>
                                    <?php endif ?>
                                    </div>
                                    <div class="mws-form-col-4-8 alpha">
                                    <label class="mws-form-label">Carica nuovo ccia</label>
                                    <div class="mws-form-item large">
                                    <input type="file" name="ccia" />
                                    </div>
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
                            	<input type="submit" class="btn btn-danger" value="Modifica Concessionario"/>
                            </div>
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
	
<?php include "include/db-connect-close.php";?>
</body>
</html>
