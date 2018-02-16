<?php
/*
 ** Change PHP  MySQL Functions to PHP MySQLI Functions
 ** Aj Osman
 ** 16-02-2018
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

<script>
function conferma(id){
var r=confirm("Vuoi davvero eliminare il cliente?");
	if (r==true){
	  window.location.assign("del_cliente.php?id="+id);
	}
}
</script>
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
            	
				<!-- End Statistics Button Container -->
				<?php include "include/stat.php";?>	                
                <!-- Table concessionari Start -->

                <?php
                $query="SELECT * FROM concessionari, province WHERE tipo = 1 AND concessionari.id_provincia = province.id_province AND id_status >= 1 ORDER By id_concessionaria desc";
                $risultati=mysqli_query($conn, $query);
                $num=mysqli_num_rows($risultati);
                ?>
            	<div class="mws-panel grid_8">
                	<div class="mws-panel-header">
                    	<span><i class="icon-table"></i> Elenco clienti</span>
                    </div>
                    <div class="mws-panel-body no-padding">
                    <?php
                    if (isset($_GET['msg'])) {
                    $avviso_num = $_GET['msg'];
                    if ($avviso_num == 1) {
                    $type= "success";
                    $title= "Perfetto";
                    $msg = "Concessionario inserito correttamente";
                     }
                     if ($avviso_num == 2) {
                    $type= "success";
                    $title= "Perfetto";
                    $msg = "Concessionario eliminato correttamente";
                     }
                     if ($avviso_num == 3) {
                    $type= "error";
                    $title= "Attenzione";
                    $msg = "Nessun concessionario con questo id";
                     }
                      if ($avviso_num == 4) {
                    $type= "success";
                    $title= "Perfetto";
                    $msg = "Concessionario modificato con successo";
                     }
                    ?>
					<div class="mws-form-message <?php echo $type; ?>">
                        <?php echo $title; ?>
                        <ul>
                            <li><?php echo $msg; ?></li>
                        </ul>
                    </div>
                    <?php }  ?>

                    <table class="mws-datatable-fn mws-table">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Città</th>
                                <th>Provincia</th>
                                <th>Telefono</th>
                                <th>E-mail</th>
                                <th>Tools</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $i=0;
                            while ($i < $num) {
                            $id=mysqli_result($risultati,$i,"id_concessionaria");
                            $nome_concessionaria=mysqli_result($risultati,$i,"nome_concessionaria");
                            $nome_province=mysqli_result($risultati,$i,"nome_province");
                            $email=mysqli_result($risultati,$i,"email");
                            $citta=mysqli_result($risultati,$i,"citta");
                            $telefono=mysqli_result($risultati,$i,"telefono");
                            ?>
                            <tr>
                                <td><?php echo $nome_concessionaria;?></td>
                                <td><?php echo $citta;?></td>
                                <td><?php echo $nome_province;?></td>
                                <td><?php echo $telefono;?></td>
                                <td><?php echo $email;?></td>
                                <td>
                                    <div class="btn-group">
                                        <!--<a href="view_concessionario.php?id=<?php echo $id;?>" class="btn btn-small"><i class="icol-application"></i> Visualizza</a>-->
                                        <a href="edit_clienti.php?id=<?php echo $id;?>" class="btn btn-small"><i class="icol-pencil"></i> Modifica</a>
										<a href="javascript:void(0);" onclick="conferma(<?php echo $id;?>);" class="btn btn-small"><i class="icol-delete"></i> Cancella</a>
									</div>
                                </td>
                            </tr>
                            <?php $i++; }  ?>
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

    <script type="text/javascript" src="./js/common.js"></script>
    
    <!-- Core Script -->
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/core/mws.js"></script>

    <!-- Themer Script (Remove if not needed) -->
    <script type="text/javascript" src="js/core/themer.js"></script>

    <!-- Demo Scripts (remove if not needed) -->
    <script type="text/javascript" src="js/demo/demo.table.js"></script>
	
	<?php include "include/db-connect-close.php";?>

</body>
</html>
