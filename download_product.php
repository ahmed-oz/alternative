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

$name = "";
$id_auto = $_GET['id_auto'];

$result = mysqli_query($conn,"SELECT marca FROM auto WHERE id=$id_auto");
if(mysqli_num_rows($result)) $name = mysqli_result($result,0,0);
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
<link rel="stylesheet" type="text/css" href="plugins/prettyphoto/css/prettyPhoto.css" media="screen">
<link rel="stylesheet" href="plugins/plupload/jquery.plupload.queue.css" media="screen" />

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

<!-- User Stylesheet -->
<link rel="stylesheet" type="text/css" href="css/user.style.css" media="screen" />

<title>Sabiana - Product download</title>

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
				<!--<?php include "include/stat.php";?>-->
				<!-- End Statistics Button Container -->
               
				<!-- File Uploader -->
				<div class="mws-panel grid_8">
                	<div class="mws-panel-header">
                    	<span><i class="icon-upload"></i> Upload file to car: <?= $name; ?> </span>
                    </div>
                    <div class="mws-panel-body no-padding">
                    	<form class="mws-form" action="upload_download_product.php" method="post" id="form-download-upload" enctype="multipart/form-data">
							<input type="hidden" name="id_product" value="<?= $id_product; ?>"/>
                        	<div class="mws-form-inline">
                                <div class="mws-form-row">
                                    <label class="mws-form-label">Documenti</label>
                                    <div class="mws-form-item large">
                                    	<div class="mws-form-cols clearfix">
                                            <div class="mws-form-col-4-8 alpha">
                                                <div class="mws-form-item large">
                                                    <input type="file" class="required file-upload" name="download_file" data-id="1"/>
													<label for="download_file" class="error" generated="true" style="display:none"></label>
                                                </div>
                                            </div>
                                            <div class="mws-form-col-2-8">
                                                <div class="mws-form-item">
													<input type="text" name="description" data-id="1"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                    		<div class="mws-button-row">
                    			<input type="submit" value="Submit" class="btn btn-danger">
                    			<input type="reset" value="Reset" class="btn ">
                    		</div>
                        </form>
                    </div>
                </div>
				<!-- File Uploader End -->
				
                <!-- Persone Table Start 
            	<div class="mws-panel grid_8">
                	<div class="mws-panel-header">
                    	<span><i class="icon-table"></i> Documenti attualmente caricati</span>
                    </div>
                    <div class="mws-panel-body no-padding">
						<!-- Output Message -->
						<?php include "include/output_msg.php";?>			
						<!-- Output Message End -->
                        <table id="download-product-table" class="mws-datatable-fn mws-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Link</th>
                                    <th>Category</th>
                                    <th>Permission</th>
                                    <th>Status</th>
                                    <th>Tools</th>
                                </tr>
                            </thead>
                            <tbody>
							<?
							$query = "SELECT * FROM download, user_level WHERE download.id_level=user_level.id_level AND status=1 AND id_product=$id_product AND download.type='product'";
							$result = mysqli_query($conn, $query);
							$num = mysqli_num_rows($result);
							$i = 0;
							while($i < $num) {
								$id_download = mysqli_result($result,$i,"id");
								$link = mysqli_result($result,$i,"link");
								$id_category = mysqli_result($result,$i,"id_category");
								$permission = mysqli_result($result,$i,"type_level");
								$status = mysqli_result($result,$i,"status");
								
								$cat_res = mysqli_query($conn,"SELECT name_en FROM download_category WHERE id_download_category = $id_category;"); // ********** name_en **********
								$category = mysqli_result($cat_res,0,"name_en"); // **********
							?>
                                <tr>
                                    <td><?= $id_download; ?></td>
									<td><?= $link; ?></td>
									<td><?= $category; ?></td>
                                    <td><?= $permission; ?></td>
									<td><? if($status) { ?>
										<span class="badge badge-success"><i class="icon-ok"></i></span>
										<? } else { ?>
										<span class="badge"><i class="icon-remove"></i></span>
										<? } ?>
									</td>
                                    <td>
										<span class="btn-group">
											<!--<a href="persone.php?id_download=<?= $id_download; ?>" class="btn btn-small modify-modal" alt="Modifica" title="Modifica" ><i class="icon-pencil"></i></a>-->
											<a href="del_download_product.php?id_download=<?= $id_download; ?>&id_product=<?= $id_product; ?>" class="btn btn-small"  alt="Del this" title="Del this" ><i class="icon-trash"></i></a>
										</span>
									</td>
                                </tr>
							<? 	$i++; } ?>
                            </tbody>
                        </table>
                    </div>
                </div>    
           Persone Table End -->
				
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
    <script type="text/javascript" src="jui/js/globalize/cultures/globalize.culture.it-IT.js"></script>

    <!-- Plugin Scripts -->
    <script type="text/javascript" src="plugins/validate/jquery.validate-min.js"></script>
    <script type="text/javascript" src="plugins/datatables/jquery.dataTables.min.js"></script>
	
	<script type="text/javascript" src="./js/common.js"></script>
	
    <!-- Core Script -->
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/core/mws.js"></script>

    <!-- DOM Scripts (remove if not needed) -->
	
    <!-- personalizzazioni -->
    <script type="text/javascript" src="js/user/table.js"></script>
	
	<script type="text/javascript">
		$(document).ready(function() {
			/*$('input:file').change(function() {
				alert($(this).val());
			});*/
			
			// Validation
			if( $.validator ) {
				$("#form-download-upload").validate({
					rules: {
						download_file: {
						  required: true,
						  accept: "pdf|zip|ppt|rar|dwg|dxf|rtf|doc|txt|jpe?g|png|gif|xls|docx|xlsx|pptx"
						}
					}
				});
			}
			
			
			
		});
		/*
		$(function(){
			$('form#form-download-upload').submit(function(event){
				var file = $('input[type="file"]').val();
				var exts = ['doc','docx','rtf','odt','zip'];
				// first check if file field has any value
				if ( file ) {
					// split file name at dot
					var get_ext = file.split('.');
					// reverse name to check extension
					get_ext = get_ext.reverse();
					// check file type is valid as given in 'exts' array
					if ( $.inArray ( get_ext[0].toLowerCase(), exts ) > -1 ){
						alert( 'Allowed extension!' );
					} else {
						alert( 'Invalid file!' );
						event.preventDefault();
					}
				}
			});
		});*/
		
		
	</script>
</body>
</html>
<?php include "include/db-connect-close.php";?>