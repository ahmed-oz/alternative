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

$id = htmlspecialchars($_GET['id']);
$query = mysqli_query($conn,"SELECT auto.*, concessionari.nome_concessionaria, auto.id_status as autoidstatus FROM auto, concessionari WHERE concessionari.id_concessionaria = auto.id_concessionario AND id = {$id}");
$quanti = mysqli_num_rows($query);
if($quanti == 1) {
	$row = mysqli_fetch_array($query);
	
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
		  $sql = "SELECT concessionari_auto.* , concessionari.nome_concessionaria FROM concessionari_auto INNER JOIN concessionari ON concessionari_auto.id_concessionari = concessionari.id_concessionaria WHERE id_auto = ".$id_auto." LIMIT 0,1";
		  $rowB = mysqli_query($conn, $sql);
		  $blocco_dati = mysqli_fetch_array($rowB);
		  break;
		case "4":
		  $status_auto ="venduta";
	   break;
	}
}
?>
<div id="scheda">
    <table class="mws-table">
        <tbody>
        	<tr style="background-color: #C5D52B;">
                <td colspan="2">Dati</td>
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
			<?php  if ($_SESSION['id_livello_sessione'] >= 3) { ?>
			<tr>
				<td>auto caricata da:</td><td><?php echo $nome_concessionaria;?></td>
			</tr>
			<?php } ?>
			<tr>
                <td>kw</td><td><?php echo $kw;?></td>
            </tr>
			<tr>
				<td>colore</td><td><?php echo $colore;?></td>
			</tr>
			<tr>
				<td>ubicazione</td><td><?php echo $ubicazione;?></td>
            </tr>
            <tr>
				<td>danni</td><td><?php echo $danni;?></td>
            </tr> 
			<tr>
				<td>iva deducibile</td><td><?= ($iva_deducibile == 1) ? "si" : "no" ?></td>
			</tr>
			<tr style="background-color: #C5D52B;">
                <td colspan="2">Equipaggiamento</td>
			</tr>
			<tr>
				<td colspan="2">
					<?php 
					$query_equipaggiamento="SELECT * FROM accessori_auto,accessori WHERE accessori.id = accessori_auto.id_accessori AND accessori_auto.id_auto = $id_auto ORDER by accessorio";
					$risultati_equipaggiamento=mysqli_query($conn, $query_equipaggiamento);
					$num=mysqli_num_rows($risultati_equipaggiamento);
					if ($num > 0) {
						$i=0;
						while ($i < $num) {
							$accessorio=mysqli_result($risultati_equipaggiamento,$i,"accessorio");
							echo $accessorio . "; ";
							$i++;
						}
					}
					?>		
				</td>
			</tr>
        </tbody>
    </table>
</div>
<?php /* Aggiunto da Gianluca - 20170112 */ ?>