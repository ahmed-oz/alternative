<?php
/*
 ** Change PHP  MySQL Functions to PHP MySQLI Functions
 ** Aj Osman
 ** 16-02-2018
*/

include "include/livello2.php";
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
<link rel="stylesheet" href="plugins/plupload/jquery.plupload.queue.css" media="screen" />
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
                $id_auto = htmlspecialchars($_GET['id']);
                $_SESSION['$lastid'] = $id_auto;

                 $query = mysqli_query($conn,"SELECT * FROM auto WHERE id = $id_auto");
                    $quanti = mysqli_num_rows($query);
                    if ($quanti == 0)
                    {
                        $error = "<div class='mws-form-message error'>Attenzione!<ul><li>Nessuna auto con questo valore.</li></ul></div>";
                    }
                    else
                    {
                        $rs = mysqli_fetch_row($query);
                        $id_auto = $rs[0];
                        $targa = $rs[1];
                        $marca = $rs[2];
                        $modello = $rs[3];
                        $allestimento = $rs[4];
                        $km = $rs[5];
                        $colore= $rs[7];
                        $prezzo = $rs[11];

                    }
                ?>
                <!-- Panels Start -->
				<div class="mws-panel grid_8">
                	<div class="mws-panel-header">
                    	<span><i class="icon-table"></i> Auto <?php echo $marca. " " .$modello;?></span>
                    </div>
					<?php echo $error; ?>
                    <div class="mws-panel-body no-padding">
                        <table class="mws-table">
                            <thead>
                                <tr>
                                    <th>VU</th>
                                    <th>allestimento</th>
                                    <th>km</th>
                                    <th>colore</th>
                                    <th>prezzo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo $id_auto;?></td>
                                    <td><?php echo $allestimento;?></td>
                                    <td><?php echo $km;?></td>
                                    <td><?php echo $colore;?></td>
                                    <td><?php echo $prezzo;?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="mws-panel-toolbar" >
                        <div class="btn-toolbar">
                            <div class="btn btn-danger">
                                <a href="view_auto.php?id=<?php echo $id_auto;?>" class="btn"><i class="icol-ok"></i> Visualizza la scheda dell'auto</a>              
							</div>
                        </div>
               		</div>
                </div>
                
            	<div class="mws-panel grid_8">
                	<div class="mws-panel-header">
                    	<span><i class="icon-upload"></i> Aggiungi foto </span>
                    </div>
                    <div class="mws-panel-body no-padding">
                        <div id="uploader">
                            <p>You browser doesn't have Flash, Silverlight, Gears, BrowserPlus or HTML5 support.</p>
                        </div>
                    </div>
				</div>
				<!-- Gallery immagini Start -->	
				<div class="mws-panel grid_8">
					<div class="mws-panel-header">
                    	<span><i class="icon-pictures"></i> Immagini associate all'auto</span>
                    </div>
                    <?php
                        if (isset($_GET['msg'])) {
                            $avviso_num = $_GET['msg'];
                            if ($avviso_num == 1) {
                            $type= "success";
                            $title= "Complimenti";
                            $msg = "l'immagine è stata correttamente eliminata";
                             }
                            if ($avviso_num == 5) {
                            $type= "warning";
                            $title= "C'è stato un errore";
                            $msg = "Attenzione c'è stato un errore";
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
                    <div class="mws-panel-body">
                		<ul class="thumbnails mws-gallery">
                        <?php
                        $query="SELECT * FROM gallery_auto WHERE id_auto = $id_auto ORDER by data_inserimento";
                        $risultati= mysqli_query($conn, $query);
                        $num = mysqli_num_rows($risultati);
                        if ($num == 0)
                        {
                            echo "<li>Nessuna foto caricata associata a questa auto</li>";
                        }
                        else {
                        $i=0;
                        while ($i < $num) {
                        $nome = mysqli_result($risultati,$i,"nome_foto");
                        $descrizione_foto = mysqli_result($risultati,$i,"descrizione_foto");
                        $id_gallery_auto = mysqli_result($risultati,$i,"id_gallery_auto");
                        ?>
                			<li>
                            	<span class="thumbnail"><img src="public/<?php echo $nome; ?>" id="photo<?= $id_gallery_auto; ?>" alt="<?php echo $descrizione_foto; ?>" title="<?php echo $descrizione_foto; ?>"><?php echo $descrizione_foto; ?></span>
                                <span class="mws-gallery-overlay">
									<a href="public/<?php echo $nome; ?>" rel="prettyPhoto[gallery1]" class="mws-gallery-btn" title="<?php echo $descrizione_foto; ?>"><i class="icon-search"></i></a>
									<a href="#" class="mws-gallery-btn edit-desc-btn" id="mws-btn-dialog" photo-id="<?= $id_gallery_auto; ?>"><i class="icon-pencil"></i></a>
									<a href="javascript:void(0);" onclick="delImg('<?=$id_gallery_auto;?>');" class="mws-gallery-btn"><i class="icon-trash"></i></a>
								</span>
                			</li>
                        <?php
                        $i++;
                        }
                        }
                        ?>
         
                		</ul>
                    </div>
				</div>
				<!-- End Gallery immagini -->
									<!-- Image Description Modal -->
				<div id="mws-form-dialog">
		<form id="mws-validate" class="mws-form" action="">
			<div id="mws-validate-error" class="mws-form-message error" style="display:none;"></div>
			<div class="mws-form-inline">
				<div class="mws-form-row">
					<label class="mws-form-label">descrizione</label>
					<div class="mws-form-item large">
						<input type="text" name="description" id="dialog-description"/>
					</div>
				</div>
			</div>
		</form>
	</div>
				<!-- Modal End -->
				<div class="mws-panel grid_8">
                	<div class="mws-panel-header">
						<a name="add_docs"></a> 
                    	<span><i class="icon-upload"></i> Aggiungi documenti </span>
                    </div>
                    <div class="mws-panel-body no-padding">
                        <div id="uploader_doc">
                            <p>You browser doesn't have Flash, Silverlight, Gears, BrowserPlus or HTML5 support.</p>
                        </div>
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
    <script type="text/javascript" src="jui/js/timepicker/jquery-ui-timepicker.min.js"></script>
    <script type="text/javascript" src="jui/js/jquery.ui.touch-punch.js"></script>

    <!-- Plugin Scripts -->
    <script type="text/javascript" src="plugins/plupload/plupload.js"></script>
    <script type="text/javascript" src="plugins/plupload/plupload.flash.js"></script>
    <script type="text/javascript" src="plugins/plupload/plupload.html4.js"></script>
    <script type="text/javascript" src="plugins/plupload/plupload.html5.js"></script>
    <script type="text/javascript" src="plugins/plupload/jquery.plupload.queue/jquery.plupload.queue.js"></script>
    
    <script type="text/javascript" src="plugins/plupload/i18n/it.js"></script>
    
    <script type="text/javascript" src="plugins/colorpicker/colorpicker-min.js"></script>
    <script type="text/javascript" src="plugins/elfinder/js/elfinder.min.js"></script>
	<script type="text/javascript" src="plugins/prettyphoto/js/jquery.prettyPhoto.min.js"></script>

    <script type="text/javascript" src="./js/common.js"></script>

    <!-- Core Script -->
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/core/mws.js"></script>

    <!-- Themer Script (Remove if not needed) -->
    <script type="text/javascript" src="js/core/themer.js"></script>

    <!-- Demo Scripts (remove if not needed) -->
    <script type="text/javascript" src="js/demo/demo.files.js"></script>
	<script type="text/javascript" src="js/demo/demo.gallery.js"></script>
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
			$(".edit-desc-btn").bind("click", function (event) {
				var id_photo = $(this).attr("photo-id");
				var desc = $("#photo"+id_photo).attr("alt");
				
				$("#dialog-description").val(desc);
				
                $("#mws-form-dialog").dialog("option", {
					title: "Aggiungi descrizione dell'immagine",
                    modal: true,
					buttons: [{
						text: "Salva",
						click: function () {
							$.ajax({
								url: 'callback/edit_desc_image_product.php',
								type: 'GET',
								data: {"desc": $("#dialog-description").val(), "id": id_photo},
								success: function(data){
									$("#photo"+id_photo).attr("alt", data);
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
