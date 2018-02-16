<?php include "include/livello1.php";?>
<?php include "include/db-connect.php";?>
<?php include "include/protezione.php";?>
<?php
function printEvenOrOdd($i) {
	return ($i % 2 == 0) ? "row-even" : "row-odd";
}
?>
<?php ob_start(); ?>
<page backtop="7mm" backbottom="7mm" backleft="10mm" backright="10mm">
	<page_header>
	</page_header> 
	<page_footer>
	</page_footer>
<html>
<head>
<style>
* { background:#FFFFFF; font-family: Arial, sans-serif; font-size:16px;/*width:100%;*/ }
table { border-spacing:0; border-collapse:separate;vertical-align:top; }
.header { width:100%; background:#000000; font-size:20px; font-weight:bold; }
.header-td { color:#C5D52B; font-size:25px; background:#000000; padding:10px; }
.table-container { width:96%;min-height:100%; }
.table-box { width:100%; }
.table-box-header { width:50%; color:#C5D52B; background:#000000; padding:5px; font-weight:bold; }
.table-box-row { width:50%; padding:5px; }
.table-box-img { width:33%; padding:5px; }
.table-gallery { width:100%; margin:0 auto; }
.width-100 { width:100%; }
.row-even { background:#CCCCCC; }
.row-green { background:#C5D52B; font-weight:bold; }
.row-align-right { text-align:right; }
img.thumb { width:100%; margin: 0 auto; }
</style>
</head>
	<body width="100%">
	<?php
	if(isset($_GET['id']) && $_GET['id']) {
	
		$id_auto = intval($_GET['id']);

		// permette ad Alternativa di visualizzare tutte le auto anche bloccate, vendute, ecc..
		if ($_SESSION['id_livello_sessione'] >= 3) {
			$query = @mysql_query("SELECT auto.*, concessionari.nome_concessionaria , auto.id_status as autoidstatus 
									FROM auto, concessionari 
									WHERE concessionari.id_concessionaria = auto.id_concessionario AND id = $id_auto");
		} else {
			$query = @mysql_query("SELECT auto.*, concessionari.nome_concessionaria, auto.id_status as autoidstatus 
									FROM auto, concessionari 
									WHERE concessionari.id_concessionaria = auto.id_concessionario AND id = $id_auto AND auto.id_status >= 1");
		}
		
		if(mysql_num_rows($query) > 0) {	
			$row = mysql_fetch_array($query);
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
			// se prezzo modificato dalla scheda dell'auto
			$pp = intval($_GET['pp']);
			if(isset($_GET['pp']) && !empty($pp)) {
				$prezzo = $pp;
			} else {
				$prezzo = $row['prezzo'];
			}
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
				  $sql = "SELECT concessionari_auto.* , concessionari.nome_concessionaria 
							FROM concessionari_auto INNER JOIN concessionari ON concessionari_auto.id_concessionari = concessionari.id_concessionaria 
							WHERE id_auto = ".$id_auto." LIMIT 0,1";
				  $rowB = mysql_query($sql); 
				  $blocco_dati = mysql_fetch_array($rowB);
				  break;
				case "4":
				  $status_auto ="venduta";
			   break;
			}
			?>
			<table class="header">
				<tr class="header-tr">
					<td class="header-td" style="width:75%;"><?php echo $_SESSION['nome_concessionaria_sessione'];?></td>
					<td class="header-td" style="width:25%;"><?php echo date('d/m/Y'); ?></td>
				</tr>
			</table>
			<br /><?php $n = 1; ?>
			<table class="table-container" style="width:750px;">
				<tr>
					<td style="width:50%;" valign="top">
						<table class="table-box">
							<tr>
								<td class="table-box-header width-100" colspan="2"><?php echo $marca. " " .$modello;?></td>
								<!--<td class="table-box-header row-align-right">VO <?php echo $id_auto;?></td>-->
							</tr>
							<tr>
								<td class="table-box-header width-100 row-align-right" colspan="2">VO <?php echo $id_auto;?></td>
							</tr>
							<tr>
								<td class="table-box-row <?php echo printEvenOrOdd($n); ?>">allestimento</td>
								<td class="table-box-row <?php echo printEvenOrOdd($n); ?>"><?php echo $allestimento;?></td>
							</tr><?php $n++; ?>
							<tr>
								<td class="table-box-row <?php echo printEvenOrOdd($n); ?>">km</td>
								<td class="table-box-row <?php echo printEvenOrOdd($n); ?>"><?php echo number_format($km, 0, ',', '.');?></td>
							</tr><?php $n++; ?>
							<tr>
								<td class="table-box-row <?php echo printEvenOrOdd($n); ?>">cavalli</td>
								<td class="table-box-row <?php echo printEvenOrOdd($n); ?>"><?php echo $cv;?></td>
							</tr><?php $n++; ?>
							<tr>
								<td class="table-box-row <?php echo printEvenOrOdd($n); ?>">kw</td>
								<td class="table-box-row <?php echo printEvenOrOdd($n); ?>"><?php echo $kw;?></td>
							</tr><?php $n++; ?>
							<tr>
								<td class="table-box-row <?php echo printEvenOrOdd($n); ?>">cilindrata</td>
								<td class="table-box-row <?php echo printEvenOrOdd($n); ?>"><?php echo $cc;?></td>
							</tr><?php $n++; ?>
							<tr>
								<td class="table-box-row <?php echo printEvenOrOdd($n); ?>">alimentazione</td>
								<?php $res = mysql_query("SELECT nome_alimentazione FROM alimentazione WHERE id='$alimentazione';"); ?>
								<td class="table-box-row <?php echo printEvenOrOdd($n); ?>"><?php echo (@mysql_result($res,0,0))?:'---'; ?></td>
							</tr><?php $n++; ?>
							<tr>
								<td class="table-box-row <?php echo printEvenOrOdd($n); ?>">immatricolazione</td>
								<?php $immatricolazione = (isValidDateTime($immatricolazione . " 00:00:00") ? date("m/Y" , strtotime($immatricolazione)) : "--/----"); ?>
								<td class="table-box-row <?php echo printEvenOrOdd($n); ?>"><?php echo $immatricolazione;?></td>
							</tr><?php $n++; ?>
							<tr>
								<td class="table-box-row <?php echo printEvenOrOdd($n); ?>">colore</td>
								<td class="table-box-row <?php echo printEvenOrOdd($n); ?>"><?php echo $colore;?></td>
							</tr><?php $n++; ?>
							<?php if( is_numeric($listino) && $listino != "" ): ?>
							<tr>
								<td class="table-box-row <?php echo printEvenOrOdd($n); ?>">listino</td>
								<td class="table-box-row <?php echo printEvenOrOdd($n); ?>"><?php echo number_format($listino, 0, ',', '.');?> €</td>
							</tr><?php $n++; ?>
							<?php endif; ?>
							<tr>
								<td class="table-box-row <?php echo printEvenOrOdd($n); ?>">danni</td>
								<td class="table-box-row <?php echo printEvenOrOdd($n); ?>"><?php echo $danni;?></td>
							</tr><?php $n++; ?>
							<tr>
								<td class="table-box-row row-green">prezzo di vendita</td>
								<td class="table-box-row row-green">
									<?php echo number_format($prezzo, 0, ',', '.');?> €
								</td>
							</tr>
						</table>
						<br />
						<table class="table-box">
							<tr><td class="table-box-header width-100">Danni (dettaglio)</td></tr>
							<tr><td class="table-box-row width-100"><?php if ($danni_dettaglio == "") { echo "Nessun dettaglio danni"; } else { echo $danni_dettaglio;}?></td></tr>
						</table>
						<br />
						<table class="table-box">
							<tr><td class="table-box-header width-100">Note</td></tr>
							<tr><td class="table-box-row width-100 notes" style="overflow:hidden;"><?php if ($note == "") { echo "Nessuna nota inserita per questa auto";} else { echo strip_tags($note, "<p><a><ul><ol><li><hr><b><strong><i><u><em><sub><sup><br>"); }?></td></tr>
						</table>
						
						
					</td>
					<td style="width:50%;height:900px;" valign="top">
						<table class="table-box" style="margin:0 auto;">
							<tr><td class="table-box-header">Equipaggiamento</td></tr>
							<?php 
							$query="SELECT * FROM accessori_auto,accessori
									WHERE accessori.id = accessori_auto.id_accessori AND accessori_auto.id_auto = $id_auto 
									ORDER by accessorio";
							$risultati=mysql_query($query);
							$num=mysql_numrows($risultati);
							if ($num == 0) {
								?><tr><td class="table-box-row">Nessun accessorio inserito su questa auto</td></tr><?php
							} else {
								$i=0;
								while ($i < $num) {
									$accessorio=mysql_result($risultati,$i,"accessorio"); ?>
									<tr><td class="table-box-row <?php echo printEvenOrOdd($i+1); ?> width-100"><?php echo $accessorio;?></td></tr>
									<?php 
									$i++;
								}
							}
							?>
						</table>
					</td>
				</tr>
			</table>
			<br />
		<nobreak>
			<table class="header">
				<tr class="header-tr">
					<td class="header-td" style="width:75%;"><?php echo $_SESSION['nome_concessionaria_sessione'];?></td>
					<td class="header-td" style="width:25%;"><?php echo date('d/m/Y'); ?></td>
				</tr>
			</table>
			<br />
			<table class="table-box">
				<tr><td class="table-box-header width-100">Immagini associate all'auto</td></tr>
				<tr><td class="width-100" style="text-align:center; vertical-align:top; min-height:700px;">
					<!--<table class="table-gallery" style="margin:0 auto;height:700px;">
					<?php /*
					$query="SELECT * FROM gallery_auto WHERE id_auto = $id_auto ORDER BY data_inserimento";
					$risultati=mysql_query($query);
					$num=mysql_numrows($risultati);
					if ($num == 0) { ?>
						<tr><td>Nessuna foto caricata associata a questa auto</td></tr>
					<?php
					}
					else {
						?><tr><?php
						$i=0;
						
						do {
							if($i%3==0) { ?></tr><tr><?php }
							
							$nome=mysql_result($risultati,$i,"nome_foto");
							$descrizione_foto=mysql_result($risultati,$i,"descrizione_foto");
							$id_gallery_auto=mysql_result($risultati,$i,"id_gallery_auto");
							?>
							<td class="table-box-img">
								<img src="public<?php echo $nome; ?>" id="photo<?php echo $id_gallery_auto; ?>" class="thumb" />
								<!--<img src="public/p18edfdlcn1k6aec92v27h51cl87.jpg" style="page-break-before:always;" class="thumb" >-->
							</td>
							<?php 
							$i++;		
						} while ($i < $num);
						
						while($i%3!=0) { 
							$i++;
							?><td class="table-box-img"></td><?php
						}
						?></tr><?php
					}*/
					?>
					</table>-->
				</td></tr>
			</table>
			
			
			<?php
				$query="SELECT * FROM gallery_auto WHERE id_auto = $id_auto ORDER BY data_inserimento";
				$risultati=mysql_query($query);
				$num=mysql_numrows($risultati);
				if ($num == 0) { ?>
					<table><tr><td>Nessuna foto caricata associata a questa auto</td></tr></table>
				<?php
				}
				else {
					?><table class="table-box"><tr><?php
					$i=0;
					
					do {
						if($i%3==0) { ?></tr></table><table class="table-box"><tr><?php }
						
						$nome=mysql_result($risultati,$i,"nome_foto");
						$descrizione_foto=mysql_result($risultati,$i,"descrizione_foto");
						$id_gallery_auto=mysql_result($risultati,$i,"id_gallery_auto");
						?>
						<td class="table-box-img">
							<img src="public<?php echo $nome; ?>" id="photo<?php echo $id_gallery_auto; ?>" class="thumb" />
							<!--<img src="public/p18edfdlcn1k6aec92v27h51cl87.jpg" style="page-break-before:always;" class="thumb" >-->
						</td>
						<?php 
						$i++;		
					} while ($i < $num);
					
					while($i%3!=0) { 
						$i++;
						?><td class="table-box-img"></td><?php
					}?></tr><?php
					?></table><?php
				}
			?>
			
		</nobreak>
		<?php
		
		} else {
			$error = "Errore: elemento non trovato";
		}

	} else {
		$error = "Errore: parametri errati";
	} ?>
	<!-- fine -->

	</body>
</html>
</page>
<?php
//die;
if(!$error) {
	$content = ob_get_clean(); 
	require_once('./html2pdf/html2pdf.class.php'); 
	$pdf = new HTML2PDF('P','A4','it', array(2, 5, 2, 5));
	//$pdf->addTTFfont('/fonts/VERDANA.TTF', 'TrueTypeUnicode', '', 32);
	$pdf->addFont('verdana', '', 'fonts/Verdana.php');
	$pdf->WriteHTML($content); 
	$pdf->Output();
} else {
	echo $error;
}

?>