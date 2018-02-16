<!--
 ** Change PHP  MySQL Functions to PHP MySQLI Functions
 ** Aj Osman
 ** 16-02-2018
 -->
<div id="mws-navigation">
    <ul>
        <li>
            <a href="#">
                <i class="icon-truck"></i>Automobili
            </a>

            <ul>
                <li>
                    <a href="gestione_auto.php">Elenco auto</a>
                </li>

                <?php if ($_SESSION['id_livello_sessione'] == 2) { //Concessionario?>
                <li><a href="add_auto.php">Nuovo inserimento auto</a></li>
    			<li><a href="myauto_to_approve.php">Auto da approvare</a></li>
    			<li><a href="myauto.php">Le mie auto</a></li>
    			<li><a href="auto_bloccate.php">Elenco auto bloccate</a></li>
                <?php } elseif ($_SESSION['id_livello_sessione'] >= 3) {  //Alternativa?>
    			<li><a href="add_auto.php">Nuovo inserimento auto</a></li>
    			<li><a href="myauto.php">Le mie auto</a></li>
    			<li><a href="gestione_accessori.php">Gestione accessori</a></li>
    			<?php } ?>

                <?php if ($_SESSION['id_livello_sessione'] >= 3) { ?>
    			<li><a href="auto_daapprovare.php">Elenco auto da approvare</a></li>
    			<li><a href="auto_bloccate.php">Elenco auto bloccate</a></li>
    			<?php } ?>

                <?php if ($_SESSION['id_livello_sessione'] > 2) { ?>
    				<li><a href="auto_vendute.php">Elenco auto vendute</a></li>
    			<?php } elseif ($_SESSION['id_livello_sessione'] == 2) { ?>
    			<li><a href="auto_vendute.php">Elenco auto acquistate</a></li>
    			<?php } ?>
            </ul>
        </li>

        <?php if ($_SESSION['id_livello_sessione'] >= 3) { ?>
        <li>
            <a href="#"><i class="icon-list"></i> Concessionari</a>
            <ul>
                <li><a href="gestione_concessionari.php">Elenco</a></li>
                <li><a href="add_concessionari.php">Nuovo</a></li>
            </ul>
        </li>

        <li>
            <a href="#"><i class="icon-list"></i> Clienti</a>
            <ul>
                <li><a href="gestione_clienti.php">Elenco</a></li>
                <li><a href="add_clienti.php">Nuovo</a></li>
            </ul>
        </li>
        <?php } ?>

        <?php
        /* Aggiunto da Gianluca - 20170112 */
        if (isset($_SESSION['id_amministratore_sessione'])) {
            $query_concessionari = "SELECT * FROM concessionari WHERE tipo = 0 AND id_status >= 1 AND id_livello NOT IN (98,99) ORDER BY nome_concessionaria ASC";
            $risultati_concessionari = mysqli_query($conn,$query_concessionari);
            $num_concessionari=mysqli_num_rows($risultati_concessionari);
            $query_clienti = "SELECT * FROM concessionari WHERE tipo = 1 AND id_status >= 1 AND id_livello NOT IN (98,99) ORDER BY nome_concessionaria ASC";
            $risultati_clienti = mysqli_query($conn,$query_clienti);
            $num_clienti=mysqli_num_rows($risultati_clienti);
            $query_amministratori = "SELECT * FROM concessionari WHERE id_status >= 1 AND id_livello IN (98,99) ORDER BY nome_concessionaria ASC";
            $risultati_amministratori = mysqli_query($conn,$query_amministratori);
            $num_amministratori=mysqli_num_rows($risultati_amministratori);
        ?>

         <li>
             <a href="#"><i class="icon-user"></i> Cambia Utente</a>
             <ul>
                 <li>
                     <select id="user_change" style="width: 100%;">
                         <optgroup label="Concessionari">
                             <?php $i=0;
                             while ($i < $num_concessionari) {
                                 $id_concessionaria=mysqli_result($risultati_concessionari, $i, "id_concessionaria");
                                 $nome_concessionaria=mysqli_result($risultati_concessionari, $i, "nome_concessionaria");
                                 $selected = $id_concessionaria == $_SESSION['id_utente_sessione'] ? ' selected' : ''; ?>
                                 <option value="<?php echo $id_concessionaria ?>"<?php echo $selected; ?>><?php echo $nome_concessionaria; ?></option>
                                 <?php $i++; } ?>
                         </optgroup>

                         <optgroup label="Clienti">
                             <?php $i=0;
                             while ($i < $num_clienti) {
                                 $id_concessionaria=mysqli_result($risultati_clienti, $i, "id_concessionaria");
                                 $nome_concessionaria=mysqli_result($risultati_clienti, $i, "nome_concessionaria");
                                 $selected = $id_concessionaria == $_SESSION['id_utente_sessione'] ? ' selected' : ''; ?>
                                 <option value="<?php echo $id_concessionaria ?>"<?php echo $selected; ?>><?php echo $nome_concessionaria; ?></option>
                                 <?php $i++; } ?>
                         </optgroup>

                         <optgroup label="Amministratori">
                             <?php $i = 0;
                             while ($i < $num_amministratori) {
                                 $id_concessionaria=mysqli_result($risultati_amministratori, $i, "id_concessionaria");
                                 $nome_concessionaria=mysqli_result($risultati_amministratori, $i, "nome_concessionaria");
                                 $selected = $id_concessionaria == $_SESSION['id_utente_sessione'] ? ' selected' : ''; ?>
                                 <option value="<?php echo $id_concessionaria ?>"<?php echo $selected; ?>><?php echo $nome_concessionaria; ?></option>
                                 <?php $i++; } ?>
                         </optgroup>
                     </select>
                 </li>
             </ul>
         </li>

         <?php }   ?>

    </ul>
</div>
