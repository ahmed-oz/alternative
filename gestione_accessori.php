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

if( $_SESSION["id_livello_sessione"] <= 2 ){
	goToPage("view_profile.php?msg=1");
	die;
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
               
                
                <!-- Table Start -->
				<?php
				$query="SELECT * FROM accessori ORDER BY accessorio";
				$risultati=mysqli_query($conn, $query);
				$num = mysqli_num_rows($risultati);
				?>                
            	<div class="mws-panel grid_8">
                	<div class="mws-panel-header">
                    	<span><i class="icon-table"></i> Gestionale accessori</span>
                    	<span style="float: right; margin: -25px 10px 0 0;"><a href="javascript:void(0);" class="add-acc-btn">+ Aggiungi accessorio</a></span>
                    </div>
					<?php  
					    if (isset($_GET['msg'])) { 
								$avviso_num = $_GET['msg'];
								if ($avviso_num == 1) {
								$type= "success";
								$title= "Complimenti";
								$msg = "L'accessorio: ".$_GET['description']." è stato modificato correttamente ";
								 }
								 if ($avviso_num == 2) {
								$type= "success";
								$title= "Complimenti";
								$msg = "L'accessorio ".$_GET['description']." è stato aggiunto correttamente";
								 }
								  if ($avviso_num == 3) {
								$type= "success";
								$title= "Complimenti";
								$msg = "L'accessorio è stata rimosso correttamente";
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
                        <table class="mws-datatable-fn mws-table">
                            <thead>
                                <tr>
                                    <th><b>VO</b></th>
                                    <th>Accessori</th>								
                                    <th>Tools</th>
                                </tr>
                            </thead>
                            <tbody>
							
							<?php
							$i=0;
							while ($i < $num) {
							$id=mysqli_result($risultati,$i,"id");
							$accessorio=mysqli_result($risultati,$i,"accessorio");
							?>
                                <tr>
                                    <td><b><?php ( $i<9 ) ? $p = 0 : $p= ''; echo $p.($i+1); ?></b></td>
                                    <td id="accessorio<?= $id; ?>" val="<?= $accessorio ?>"><?php echo $accessorio;?></td>									
                                    <td>
									<div class="btn-group">
										<a href="javascript:void(0);" class="edit-desc-btn btn btn-small"  accessorio-id="<?= $id; ?>" alt="Modifica" title="Modifica"><i class="icol-pencil"></i></a>
										<a href="javascript:void(0);" onclick="conferma('<?php echo $id;?>', 'l\'accessorio')" class="btn btn-small" alt="Cancella" title="Cancella"><i class="icol-delete"></i></a>
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
        
	<!-- Modifica accessorio Modal -->
	<div id="mws-form-dialog">
		<form id="mws-validate" class="mws-form" action="">
			<div id="mws-validate-error" class="mws-form-message error" style="display:none;"></div>
			<div class="mws-form-inline">
				<div class="mws-form-row">
					<label class="mws-form-label">Nome accessorio:</label>
					<div class="mws-form-item large">
						<input type="text" name="description" id="dialog-description"/>
					</div>
				</div>
			</div>
		</form>
	</div>
        
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
    <!-- <script type="text/javascript" src="plugins/elfinder/js/elfinder.min.js"></script>
	<script type="text/javascript" src="plugins/prettyphoto/js/jquery.prettyPhoto.min.js"></script -->

    <script type="text/javascript" src="./js/common.js"></script>

    <!-- Core Script -->
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/core/mws.js"></script>

    <!-- Themer Script (Remove if not needed) -->
    <script type="text/javascript" src="js/core/themer.js"></script>

    <!-- Demo Scripts (remove if not needed) -->
    <script type="text/javascript" src="js/demo/demo.table.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			
        // jQuery-UI Dialog
        if( $.fn.dialog ) {
            $("#mws-jui-dialog").dialog({
                autoOpen: false,
                title: "jQuery-UI Dialog",
                modal: true,
                width: "640",
                buttons: [{
                    text: "Close Dialog",
                    click: function () {
                        $(this).dialog("close");
                    }
                }]
            });
            $("#mws-form-dialog").dialog({
                autoOpen: false,
                title: "jQuery-UI Modal Form",
                modal: true,
                width: "640",
                buttons: [{
                    text: "Submit",
                    click: function () {
                        $(this).find('form#mws-validate').submit();
                    }
                }]
            });
            $("#mws-jui-dialog-btn").bind("click", function (event) {
                $("#mws-jui-dialog").dialog("option", {
                    modal: false
                }).dialog("open");
                event.preventDefault();
            });
            $("#mws-jui-dialog-mdl-btn").bind("click", function (event) {
                $("#mws-jui-dialog").dialog("option", {
                    modal: true
                }).dialog("open");
                event.preventDefault();
            });
            $("#mws-form-dialog-mdl-btn").bind("click", function (event) {
                $("#mws-form-dialog").dialog("option", {
                    modal: true
                }).dialog("open");
                event.preventDefault();
            });
          } 
          //---------------------------------------------------------------------------- modifica nome
			$(".edit-desc-btn").live("click", function (event) {
				var id_photo = $(this).attr("accessorio-id");
				var desc = $("#accessorio"+id_photo).attr("val");
				
				$("#dialog-description").val(desc);
				
                $("#mws-form-dialog").dialog("option", {
					title: "Modifica nome accessorio",
                    modal: true,
					buttons: [{
						text: "Salva",
						click: function () {
							$.ajax({
								url: 'callback/edit_accessorio.php',
								type: 'GET',
								data: {"desc": $("#dialog-description").val(), "id": id_photo, "msg": 1},
								success: function(data){
									$("#accessorio"+id_photo).attr("alt", data);
									$("#mws-form-dialog").dialog('close');
									location.reload();
								}
							});
						}
					}]
                }).dialog("open");
                event.preventDefault();
            });
			//---------------------------------------------------------------------------- aggiungi accessorio
			$(".add-acc-btn").live("click", function (event) {
				
				$("#dialog-description").val("");
				
                $("#mws-form-dialog").dialog("option", {
					title: "Aggiungi accessorio",
                    modal: true,
					buttons: [{
						text: "Salva",
						click: function () {
							$.ajax({
								url: 'callback/add_accessorio.php',
								type: 'GET',
								data: {"desc": $("#dialog-description").val(), "msg": 2},
								success: function(data){
									$("#mws-form-dialog").dialog('close');
									location.reload();
								}
							});
						}
					}]
                }).dialog("open");
                event.preventDefault();
            });
		});
	</script>
	
	<?php include "include/db-connect-close.php";?>

</body>
</html>
