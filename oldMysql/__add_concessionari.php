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
                    	<span><i class="icon-ok"></i> Inserimento concessionaria</span>
                    </div>
                    <div class="mws-panel-body no-padding">
                    	<form id="mws-validate" class="mws-form" action="add_concessionari_process.php" method="post" enctype="multipart/form-data">
                        	<div id="mws-validate-error" class="mws-form-message error" style="display:none;"></div>
                        	<div class="mws-form-inline">
								<div class="mws-form-cols clearfix">
                                	<div class="mws-form-col-2-8 alpha">
										<label class="mws-form-label">Codice</label>
										<div class="mws-form-item large">
											<input type="text" name="codice_concessionaria" class="required" maxlength="5" />
										</div>
									</div>
								</div>
								<div class="mws-form-cols clearfix">
                                	<div class="mws-form-col-4-8 alpha">
										<label class="mws-form-label">Ragione sociale</label>
										<div class="mws-form-item large">
											<input type="text" name="nome_concessionaria" class="required" />
										</div>
									</div>
									<div class="mws-form-col-2-8">
										<label class="mws-form-label">Login</label>
										<div class="mws-form-item large">
											<input type="text" name="login" class="required" />
										</div>
									</div>
									<div class="mws-form-col-2-8 omega">
										<label class="mws-form-label">Password</label>
										<div class="mws-form-item large">
											<input type="password" name="password" class="required" />
										</div>
									</div>
								</div>
								
								<div class="mws-form-cols clearfix">
                                	<div class="mws-form-col-4-8 alpha">
										<label class="mws-form-label">Indirizzo</label>
											<div class="mws-form-item large">
											  <input type="text" name="indirizzo" class="required" />
											</div>
									</div>
									<div class="mws-form-col-2-8">
										<label class="mws-form-label">Città</label>
											<div class="mws-form-item large">
											  <input type="text" name="citta" class="required" />
											</div>
									</div>
									<div class="mws-form-col-2-8 omega">
										<label class="mws-form-label">Provincia</label>
											<div class="mws-form-item large">
											<select class="required" name="id_provincia">
                                        	<option></option>
<?php 
$query="SELECT * FROM province ORDER By nome_province";
$risultati=mysql_query($query);
$num=mysql_numrows($risultati);
while ($i < $num) {
$id=mysql_result($risultati,$i,"id_province");
$nome=mysql_result($risultati,$i,"nome_province");
?>
                    						<option value="<?php echo $id;?>"><?php echo $nome;?></option>
<?php 
$i++; 
} 
?>
											</select>
											</div>
									</div>
								</div>
								<div class="mws-form-cols clearfix">
                                	<div class="mws-form-col-3-8 alpha">
                                	<label class="mws-form-label">Email</label>
                                	<div class="mws-form-item large">
                                    	<input type="text" name="email" class="required email" />
                                    </div>
									</div>
									<div class="mws-form-col-3-8">
										<label class="mws-form-label">Sito web</label>
										<div class="mws-form-item large">
											<input type="text" name="sito_web" class="url" />
										</div>
									</div>
									<div class="mws-form-col-2-8 omega">
                                	<label class="mws-form-label">Livello</label>
                                	<div class="mws-form-item large">
                    					<select class="required" name="id_livello">
                                        	<option></option>
                    						<option value="1">Utente standard</option>
                    						<option value="2">Inserzionista</option>
                    						<option value="98">Admin</option>
                    						<option value="99">Super Admin</option>
                    					</select>
                                    </div>
									</div>
								</div>
								
								<div class="mws-form-cols clearfix">
                                	<div class="mws-form-col-4-8 alpha">
                                	<label class="mws-form-label">Telefono</label>
                                	<div class="mws-form-item large">
                                    	<input type="text" name="telefono" class="required" />
                                    </div>
									</div>
									<div class="mws-form-col-4-8 omega">
										<label class="mws-form-label">Fax</label>
										<div class="mws-form-item large">
											<input type="text" name="fax" />
										</div>
									</div>
								</div>
								
								<div class="mws-form-cols clearfix">
                                	<div class="mws-form-col-8-8 alpha">
                                	<label class="mws-form-label">Allega file CCIA</label>
                                	<div class="mws-form-item large">
                                    	<input type="file" name="ccia" class="required" />
                                        <label for="ccia" class="error" generated="true" style="display:none"></label>
                                    </div>
									</div>
								</div>
								
                        	<div class="mws-form-row">
                            	<label class="mws-form-label">Note</label>
                                <div class="mws-form-item">
                                	<textarea id="cleditor" name="note"></textarea>
                                </div>
                            </div>

                    </div>
                            <div class="mws-button-row">
                            	<input type="submit" class="btn btn-danger" value="Inserisci Concessionario"/>
                            </div>
						</div>
						
                        </form>
                    </div>    	
                <!--</div>-->
                
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
