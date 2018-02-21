<?php
/*
 ** Change PHP  MySQL Functions to PHP MySQLI Functions
 ** Aj Osman
 ** 16-02-2018
*/

ob_start();
session_start();

include "include/livello1.php";
include "include/db-connect.php";
include "include/protezione.php";
include "include/functions.php";

//mysqli_query($conn, 'SET character_set_client = \'utf8\'');

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

<style>
.show-price {
	cursor: pointer;
}
span.price-customer {
	display: none;
}
</style>

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
				mysqli_query($conn, "SET NAMES utf8;");
				$id_auto = htmlspecialchars($_GET['id']);

				// permette ad Alternativa di visualizzare tutte le auto anche bloccate, vendute, ecc..
					if ($_SESSION['id_livello_sessione'] >= 3) {
						$query = mysqli_query($conn,"SELECT auto.*, concessionari.nome_concessionaria , auto.id_status as autoidstatus FROM auto, concessionari WHERE concessionari.id_concessionaria = auto.id_concessionario AND id = $id_auto");
					} else {
						$query = mysqli_query($conn,"SELECT auto.*, concessionari.nome_concessionaria, auto.id_status as autoidstatus FROM auto, concessionari WHERE concessionari.id_concessionaria = auto.id_concessionario AND id = $id_auto AND auto.id_status >= 1");
					}
					$quanti = mysqli_num_rows($query);
					if($quanti > 0) {	
						$row = mysqli_fetch_array($query);
						//var_dump($row);
						$id_auto = $row['id'];
						$targa = $row['targa'];
						$marca = $row['marca'];
						$modello = $row['modello'];
						$allestimento = $row['allestimento'];
						$km = $row['km'];
						$cv = $row['cv'];
						$kw = $row['kw'];
						$cc = $row['cc'];
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
						$id_concessionaria = $row['id_concessionaria'];
						$nome_concessionaria = $row['nome_concessionaria'];
						$id_status = $row['autoidstatus'];
						$telaio = $row['telaio'];
						$iva_deducibile = $row['iva_deducibile'];

						switch ($id_status) {
							case "1":
							  $status_auto = "in approvazione";
							  break;
							case "2":
							  $status_auto = "disponibile";
							  break;
							case "3":
							  $status_auto ="bloccata";
							  $sql = "SELECT concessionari_auto.* , concessionari.nome_concessionaria, concessionari.tipo FROM concessionari_auto INNER JOIN concessionari ON concessionari_auto.id_concessionari = concessionari.id_concessionaria WHERE id_auto = ".$id_auto." LIMIT 0,1";
							  $rowB = mysqli_query($conn, $sql);
							  $blocco_dati = mysqli_fetch_array($rowB);
							  break;
							case "4":
							  $status_auto ="venduta";
						   break;
						}
					//}
				?>
                <!-- Dettagli auto -->
				<div class="mws-panel grid_4">
                	<div class="mws-panel-header">
                    	<span><i class="icon-table"></i> <?php echo $marca. " " .$modello;?></span>
                    </div>
					<?php  
					if (isset($_GET['msg'])) {
					$avviso_num = $_GET['msg'];
					if ($avviso_num == 1) {
						$type= "success";
						$title= "Complimenti";
						$msg = "l'auto selezionata è stata correttamente bloccata";
					}
					elseif ($avviso_num == 2) {
						$type= "error";
						$title= "Attenzione";
						$msg = "Non è stato possibile effettuare il blocco dell'auto poichè l'hai già bloccata per due volte.";
					}
					elseif ($avviso_num == 3) {
						$type= "success";
						$title= "Complimenti";
						$msg = "L'auto è stata rimossa correttamente";
					}
					elseif ($avviso_num == 4) {
						$type= "success";
						$title= "Complimenti";
						$msg = "L'auto è stata venduta";
					}
					elseif ($avviso_num == 5) {
						$type= "success";
						$title= "Complimenti";
						$msg = "L'auto è stata approvata e inserita correttamente a listino";
					}
					elseif ($avviso_num == 6) {
						$type= "success";
						$title= "Complimenti";
						$msg = "L'auto è stata modificata correttamente";
					}
					elseif ($avviso_num == 7) {
						$type= "success";
						$title= "Complimenti";
						$msg = "l'auto selezionata è stata correttamente sbloccata";
					}
					elseif ($avviso_num == 8) {
						$type= "warnig";
						$title= "Complimenti, l'auto è stata aggiunta";
						$msg = "Arricchisci la scheda inserendo immagini e documenti relativi all'auto <a href='add_auto_files.php?id=".$_GET['id_auto']."'>CLICCA QUI!</a>";
					}
					elseif ($avviso_num == 9) {
						$type= "success";
						$title= "Complimenti";
						$msg = "l'immagine è stata correttamente eliminata";
					}
					elseif ($avviso_num == 10) {
						$type= "success";
						$title= "Complimenti";
						$msg = "Il documento è stato correttamente eliminato";
					}
					elseif ($avviso_num == 99) {
						$type= "error";
						$title= "Attenzione";
						$msg = "Si è verificat un errore imprevisto";
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
                        <table class="mws-table">
                            <tbody>
                                <tr style="background-color: #C5D52B;">
                                    <td><b>VO</b></td><td><b><?php echo $id_auto;?></b></td>
								</tr>
								<?php  if ($_SESSION['id_livello_sessione'] >= 3) { ?>
								<tr>
                                    <td>targa</td><td><?php echo $targa;?></td>
								</tr>
								<tr>
									<td>numero telaio</td><td><?php echo $telaio; ?></td>
								</tr>
								<tr>
									<td >status dell'auto</td>
									<td>
										<b><?php echo $status_auto;?></b>
									</td>
								</tr>
								<?php } ?>
								<?php  if ($_SESSION['id_livello_sessione'] >= 3) { ?>
								<tr>
									<td>auto caricata da:</td><td><?php echo $nome_concessionaria;?></td>
								</tr>
								<?php } ?>
								<tr>
                                    <td>allestimento</td><td><?php echo $allestimento;?></td>
                                </tr>
								<tr>
                                    <td>km</td><td><?php echo number_format($km, 0, ',', '.');?></td>
                                </tr>
                				<tr>
                                    <td>cavalli</td><td><?php echo $cv;?></td>
                                </tr>
                				<tr>
                                    <td>kw</td><td><?php echo $kw;?></td>
                                </tr>
                				<tr>
                                    <td>cilindrata</td><td><?php echo $cc;?></td>
                                </tr>
                				<tr>
                                    <td>alimentazione</td>
									<td><?php $res = mysqli_query($conn,"SELECT nome_alimentazione FROM alimentazione WHERE id='$alimentazione';");
									echo (mysqli_result($res,0,0))?:'---'; ?></td>
                                </tr>
								<tr>
									<td>immatricolazione</td><td><?php echo date("m/Y" , strtotime($immatricolazione));?></td>
                                </tr> 
								<tr>
									<td>colore</td><td><?php echo $colore;?></td>
								</tr>
								<tr>
									<td>ubicazione</td><td><?php echo $ubicazione;?></td>
                                </tr>
                                <?php if( is_numeric($listino) && $listino != "" ): ?>
								<tr>
									<td>listino</td><td><?php echo number_format($listino, 0, ',', '.');?></td>
                                </tr> 
                                <?php endif; ?>
								<tr>
									<td>danni</td><td><?php echo $danni;?></td>
                                </tr> 
								<tr>
									<td><span style="text-decoration: underline;" class="show-price">prezzo (privato)</span><span class="price-customer"><br />prezzo (commerciante)</span></td>
									<td><span id="price-private"><?php echo number_format($prezzo, 0, ',', '.');?></span> <a href="#" id="button-pencil"><i class="icon-pencil-2"></i></a><span class="price-customer"><br /><?php echo number_format($prezzo_operatore, 0, ',', '.');?></span></td>
								</tr>
								<tr>
									<td>iva deducibile</td><td><?= ($iva_deducibile == 1) ? "si" : "no" ?></td>
								</tr>

                            </tbody>
                        </table>
                    </div>
					<div class="mws-panel-toolbar" >
                        <div class="btn-toolbar">
                            <div class="btn-group">
							<?php if ($id_status == 2) { ?>
                                <a href="blocca_auto.php?id=<?php echo $id_auto; ?>" class="btn"><i class="icol-lock"></i> Blocca</a>              
							<?php } ?>	
							<?php if ( ($id_status == 3 && $_SESSION['id_livello_sessione'] >= 3) ||  $blocco_dati['id_concessionari'] == $_SESSION['id_utente_sessione'] ) { ?>
									<a href="sblocca_auto_process.php?id_concessionari_auto=<?php echo $blocco_dati['id_concessionari_auto'];?>" class="btn"><i class="icol-lock-unlock"></i> Sblocca</a>
							<?php if($_SESSION['id_livello_sessione'] >= 3 || ($id_status == 1 && $_SESSION['id_livello_sessione'] == 2)) { ?>		
									<a href="vendita_auto.php?id=<?php echo $id_auto;?>" class="btn"><i class="icol-money-euro"></i> Vendi</a><?php } ?>
							<?php } ?>
							<?php if ($id_status == 1 && $_SESSION['id_livello_sessione'] >= 3) { ?>
								<a href="approva_auto.php?id=<?php echo $id_auto;?>" class="btn"><i class="icol-accept"></i> Approva auto</a>
							<?php } ?>
							<?php if ($_SESSION['id_livello_sessione'] >= 3 || ($id_status == 1 && $_SESSION['id_livello_sessione'] == 2)) { ?>
								<a href="edit_auto.php?id=<?php echo $id_auto;?>" class="btn" ><i class="icol-pencil"></i> Modifica</a>
								<a href="del_auto.php?id=<?php echo $id_auto;?>" class="btn"><i class="icol-delete"></i> Cancella</a>
							<?php } ?>
								<a href="add_auto.php?id=<?php echo $id_auto;?>" class="btn" ><i class="icol-application-double"></i> Duplica</a>
								<a href="print_auto_card.php?id=<?php echo $id_auto;?>" class="btn" target="_blank" id="link_pdf"><i class="icol-doc-pdf"></i> PDF</a>
							</div>
                        </div>
                    </div>
                </div>
				<!-- End Dettagli auto -->
				<?
				if(trim($blocco_dati['data_blocco_inizio'])!='' && trim($blocco_dati['data_blocco_inizio'])!='0000-00-00 00:00:00') {
				?>				
				<div class="mws-panel grid_4 mws-collapsible">
                	<div class="mws-panel-header">
                    	<span><i class="icon-table"></i>Informazioni blocco</span>
                    </div>
					<div class="mws-panel-inner-wrap" style="display: block;">
						<div class="mws-panel-body no-padding">
                        <table class="mws-table">
                            <tbody>
                            <?php
                            $sql = "SELECT concessionari_auto.* , concessionari.nome_concessionaria, concessionari.tipo FROM concessionari_auto INNER JOIN concessionari ON concessionari_auto.id_concessionari = concessionari.id_concessionaria WHERE id_auto = ".$id_auto." LIMIT 0,1";
                            $rowB = mysqli_query($conn, $sql);
                            $blocco_dati = mysqli_fetch_array($rowB, MYSQLI_ASSOC);
                            ?>
							<tr>
								<td>
									<?php /* Modificato da Gianluca - 20170117 */ ?>
									<?php if($blocco_dati['tipo']==0) { ?>
									Concessionaria
									<?php } else { ?>
									Cliente
									<?php } ?>
									<?php /* Modificato da Gianluca - 20170117 */ ?>
								</td>
								<td><?=$blocco_dati['nome_concessionaria'];?></td>
							</tr>
							<tr>
								<td>Data blocco</td>
								<td><?=date('d/m/Y H:i', strtotime($blocco_dati['data_blocco_inizio']));?></td>
							</tr>
							<tr>
								<td>Note</td>
								<td><?=$blocco_dati['note_blocco'];?></td>
							</tr>
							</tbody>
                        </table>
						</div>
					</div>
				</div>
				<?
				}
				?>
				<!-- Equipaggiamento auto -->
				<div class="mws-panel grid_4 mws-collapsible">
                	<div class="mws-panel-header">
                    	<span><i class="icon-table"></i> Equipaggiamento</span>
                    </div>
					<div class="mws-panel-inner-wrap" style="display: block;">
						<div class="mws-panel-body no-padding">
                        <table class="mws-table">
                            <tbody>
							<?php 
							$query="SELECT * FROM accessori_auto,accessori WHERE accessori.id = accessori_auto.id_accessori AND accessori_auto.id_auto = $id_auto ORDER by accessorio";
							$risultati=mysqli_query($conn, $query);
							$num=mysqli_num_rows($risultati);
							if ($num == 0)
							{
								echo "<td>Nessun accessorio inserito su questa auto</td>";
							}
							else {
								$i=0;
								while ($i < $num)
								{
									$accessorio=mysqli_result($risultati,$i,"accessorio");
									?>
									<tr>
										<td><?php echo $accessorio;?></td>
									</tr>
									<?php 
									$i++;
								}
							}
							?>		
                            </tbody>
                        </table>
                    </div>
					</div>
				</div>
				<!-- End Equipaggiamento auto -->
				
				<!-- Documenti Start -->
				<div class="mws-panel grid_4 mws-collapsible">
					<div class="mws-panel-header">
					<span>Documenti associati</span>
					</div>
					<div class="mws-panel-inner-wrap" style="display: block;">
					<div class="mws-panel-body">
					<?php 
					$query="SELECT * FROM documenti_auto WHERE id_auto = $id_auto ORDER by data_inserimento";
					$risultati=mysqli_query($conn, $query);
					$num=mysqli_num_rows($risultati);

					if ($num == 0)
					{
						echo "<p>Nessun documento associato a questa auto</p>";
					}
					else {
						$i=0;
						while ($i < $num)
						{
							$id_doc=mysqli_result($risultati,$i,"id_documento");
							$nome_documento=mysqli_result($risultati,$i,"nome_documento");
							$descrizione_documento= ( mysqli_result($risultati,$i,"descrizione_documento") == NULL) ? "Visualizza documento" : mysqli_result($risultati,$i,"descrizione_documento");
							?>					
							<p>
								<a href="public/<?php echo $nome_documento; ?>" target="_blank" alt="<?php echo $descrizione_documento; ?>" title="<?php echo $descrizione_documento; ?>"><i class="icon-file" id="doc<?= $id_doc;?>"> <?php echo $descrizione_documento; ?></i></a>
								<span class="mws-gallery-overlay" style="margin-left:50px;">
								<? if($_SESSION['id_livello_sessione'] >= 3 || ($id_status == 1 && $_SESSION['id_livello_sessione'] == 2)) {?>
									<a href="javascript:void(0);" class="mws-gallery-btn edit-desc-doc-btn" id="mws-btn-dialog" doc-id="<?= $id_doc; ?>"><i class="icon-pencil"></i></a>
									<a href="javascript:void(0);" onclick="delDoc('<?php echo $id_doc;?>')" class="mws-gallery-btn" alt="Cancella documento" title="Cancella documento"><i class="icon-trash"></i></a>
								<? }?>
								</span>
							</p>
							<?php
							$i++; 
						}
					}
					?>					
					</div>
					<div class="mws-panel-toolbar" >
                        <div class="btn-toolbar">
                            <div class="btn-group">
							<?php if($_SESSION['id_livello_sessione'] >= 3 || ($id_status == 1 && $_SESSION['id_livello_sessione'] == 2)) { ?>
								<a href="add_auto_files.php?id=<?php echo $id_auto;?>#add_docs" class="btn" ><i class="icol-pencil"></i> Aggiungi nuovi documenti</a>
							<?php } ?>
							</div>
                        </div>
                    </div>
					</div>
					
				</div>
				
				<!-- End Documenti -->
				
				<!-- Danni (dettaglio) Start -->				
				<div class="mws-panel grid_4 mws-collapsible">
					<div class="mws-panel-header">
					<span>Danni (dettaglio)</span>
					</div>
					<div class="mws-panel-inner-wrap" style="display: block;">
						<div class="mws-panel-body">
						<p><?php if ($danni_dettaglio == "") { echo "Nessun dettaglio danni"; } else { echo $danni_dettaglio;}?></p>
						</div>
					</div>
				</div>
				<!-- End Danni (dettaglio) -->
				
				<!-- Note Start -->				
				<div class="mws-panel grid_4 mws-collapsible">
					<div class="mws-panel-header">
					<span>Note</span>
					</div>
					<div class="mws-panel-inner-wrap" style="display: block;">
						<div class="mws-panel-body">
						<p><?php if ($note == "") { echo "Nessuna nota inserita per questa auto";} else { echo $note;}?></p>
						</div>
					</div>
				</div>
				<!-- End Note -->
				
				<!-- Gallery immagini Start -->	
				<div class="mws-panel grid_8">
					<div class="mws-panel-header">
                    	<span><i class="icon-pictures"></i> Immagini associate all'auto</span>
                    </div>
                    					
                    <div class="mws-panel-body">
                		<ul class="thumbnails mws-gallery">
						<?php 
						$query="SELECT * FROM gallery_auto WHERE id_auto = $id_auto ORDER by data_inserimento";
						$risultati=mysqli_query($conn, $query);
						$num=mysqli_num_rows($risultati);
						if ($num == 0)
						{
							echo "<li>Nessuna foto caricata associata a questa auto</li>";
						}
						else {
							$i=0;
							while ($i < $num)
							{
							$nome=mysqli_result($risultati,$i,"nome_foto");
							$descrizione_foto=mysqli_result($risultati,$i,"descrizione_foto");
							$id_gallery_auto=mysqli_result($risultati,$i,"id_gallery_auto");
							?>
							<li>
								<span class="thumbnail"><img src="public<?php echo $nome; ?>" id="photo<?= $id_gallery_auto; ?>" alt="<?php echo $descrizione_foto; ?>" title="<?php echo $descrizione_foto; ?>"><?php echo $descrizione_foto; ?></span>
								<span class="mws-gallery-overlay">
									<a href="public/<?php echo $nome; ?>" rel="prettyPhoto[gallery1]" class="mws-gallery-btn" title="<?php echo $descrizione_foto; ?>"><i class="icon-search"></i></a>
									<?php if( $id_status >= 2 ) { 
											if(  $_SESSION["id_livello_sessione"] >= 3 ) { ?>
												<a href="javascript:void(0);" class="mws-gallery-btn edit-desc-btn" id="mws-btn-dialog" photo-id="<?= $id_gallery_auto; ?>"><i class="icon-pencil"></i></a>
												<a href="javascript:void(0);" onclick="delImg('<?=$id_gallery_auto;?>');" class="mws-gallery-btn" alt="Cancella immagine" title="Cancella immagine"><i class="icon-trash"></i></a>
									<?php 
											}
										  }
										  else { ?>
										  	<a href="javascript:void(0);" class="mws-gallery-btn edit-desc-btn" id="mws-btn-dialog" photo-id="<?= $id_gallery_auto; ?>"><i class="icon-pencil"></i></a>
											<a href="javascript:void(0);" onclick="delImg('<?=$id_gallery_auto;?>');" class="mws-gallery-btn" alt="Cancella immagine" title="Cancella immagine"><i class="icon-trash"></i></a>
								   <?php } ?> 
								</span>
							</li>
							<?php
							$i++; 
							}
						}
						?>
                		</ul>
                    </div>
                    <div class="mws-panel-toolbar" >
                        <div class="btn-toolbar">
                            <div class="btn-group">
							<?php if($_SESSION['id_livello_sessione'] >= 3 || ($id_status == 1 && $_SESSION['id_livello_sessione'] == 2)) { ?>
								<a href="add_auto_files.php?id=<?php echo $id_auto;?>" class="btn" ><i class="icol-pencil"></i> Aggiungi nuove foto</a>
							<?php } ?>
							</div>
                        </div>
                    </div>
				</div>
				<!-- End Gallery immagini -->
					<!-- Image Description Modal -->
				<div id="mws-form-dialog">
		<form id="mws-validate" class="mws-form" action="">
			<div id="mws-validate-error" class="mws-form-message error" style="display:none;"></div>
			<div class="mws-form-inline">
				<div class="mws-form-row">
					<label class="mws-form-label">Descrizione:</label>
					<div class="mws-form-item large">
						<input type="text" name="description" id="dialog-description"/>
					</div>
				</div>
			</div>
		</form>
	</div>
				<!-- Modal End -->
				<?php 
	}
	else {  
		echo "<div class='mws-panel grid_8'><div class='mws-panel-header'><span><i class='icon-table'></i> Attenzione</span></div><div class='mws-form-message error'>Attenzione!<ul><li>L'auto che si è cercato di aprire non è ancora stata autorizzata alla vendita oppure non esiste più.</li></ul></div></div>"; 
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
    <script type="text/javascript" src="js/libs/jquery.number.min.js"></script>
    <script type="text/javascript" src="custom-plugins/fileinput.js"></script>

    <!-- jQuery-UI Dependent Scripts -->
    <script type="text/javascript" src="jui/js/jquery-ui-1.9.0.min.js"></script>
    <script type="text/javascript" src="jui/js/timepicker/jquery-ui-timepicker.min.js"></script>
    <script type="text/javascript" src="jui/js/jquery.ui.touch-punch.js"></script>

    <!-- Plugin Scripts -->
    <script type="text/javascript" src="plugins/colorpicker/colorpicker-min.js"></script>
    <script type="text/javascript" src="plugins/elfinder/js/elfinder.min.js"></script>
	<script type="text/javascript" src="plugins/prettyphoto/js/jquery.prettyPhoto.min.js"></script>

	<script type="text/javascript" src="./js/common.js"></script>

    <!-- Core Script -->
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/core/mws.js"></script>

    <!-- Demo Scripts (remove if not needed) -->
	<script type="text/javascript" src="js/demo/demo.gallery.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
		
		$('.show-price:not(input#new_price_private)').click(function() {
			$('.price-customer').toggle();
		});
		
		
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
			
			$(".edit-desc-doc-btn").bind("click", function (event) {
				var id_doc = $(this).attr("doc-id");  
				var desc = $("#doc"+id_doc).text();  
				
				if(desc=='Visualizza documento') {
					desc='';
				}
				
				$("#dialog-description").val(desc);
				
                $("#mws-form-dialog").dialog("option", {
					title: "Aggiungi una descrizione al documento",
                    modal: true,
					buttons: [{
						text: "Salva",
						click: function () {
							$.ajax({
								url: 'callback/edit_desc_doc_auto.php',
								type: 'GET',
								data: {"desc": $("#dialog-description").val(), "id": id_doc},
								success: function(data){
									//$("#doc"+id_doc).val(data);
									//$("#mws-form-dialog").dialog('close');
									location.reload();
								}
							});
						}
					}]
                }).dialog("open");
                event.preventDefault();
            });
			
			$("#button-pencil").click(function() {
				$("span#price-private").html("<input id='new_price_private' name='new_price_private' type='text' />");
				$("input[name='new_price_private']").keyup(function(e){
					if (/\D/g.test(this.value)) {
						this.value = this.value.replace(/\D/g, '');
					}
					if(e.keyCode == 13)
					{
						$("span#price-private").html( $(this).val() );
						$("span#price-private").number(true, 0, ',', '.');
						var href = $("#link_pdf").attr('href');
						href = href + "&pp=" + $(this).val();
						$("#link_pdf").attr('href', href);
					}
				});
				
				return false;
			});

		});
	</script>
	<?php include "include/db-connect-close.php"; ?>
</body>
</html>