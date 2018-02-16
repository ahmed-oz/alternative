<?php if ($_SESSION['id_livello'] >= 3) { ?>
<div class="mws-stat-container clearfix">
                	
    <!-- Statistic Item -->
    <a class="mws-stat" href="gestione_concessionari.php">
        <!-- Statistic Icon (edit to change icon) -->
        <span class="mws-stat-icon icol32-building"></span>

        <!-- Totali concessionari -->
        <?php
        $sql = "SELECT id FROM concessionari WHERE id_status >=1";
        $result=mysqli_query($conn, $sql);
        $totali_concessionari=mysqli_num_rows($result);
        ?>

        <span class="mws-stat-content">
            <span class="mws-stat-title">Totale concessionari</span>
            <span class="mws-stat-value"><?echo $totali_concessionari; ?></span>
        </span>
    </a>

    <a class="mws-stat" href="gestione_auto.php">
        <!-- Statistic Icon (edit to change icon) -->
        <span class="mws-stat-icon icol32-car"></span>

        <!-- Statistic Content -->
        <?php $sql = "SELECT id FROM auto WHERE id_status = 2";
        $result=mysqli_query($conn, $sql);
        $totale_auto=mysqli_num_rows($result);
        ?>
        <span class="mws-stat-content">
            <span class="mws-stat-title">Auto in vetrina</span>
            <span class="mws-stat-value"><?echo $totale_auto; ?></span>
        </span>
    </a>

    <a class="mws-stat" href="auto_bloccate.php">
        <!-- Statistic Icon (edit to change icon) -->
        <span class="mws-stat-icon icol32-lock"></span>
        <?php $sql = "SELECT id FROM auto WHERE id_status = 3";
        $result=mysqli_query($conn, $sql);
        $totale_auto_bloccate=mysqli_num_rows($result);
        ?>
        <!-- Statistic Content -->
        <span class="mws-stat-content">
            <span class="mws-stat-title">Auto bloccate</span>
            <span class="mws-stat-value"><?echo $totale_auto_bloccate; ?></span>
        </span>
    </a>
                    
    <a class="mws-stat" href="auto_vendute.php">
        <!-- Statistic Icon (edit to change icon) -->
        <span class="mws-stat-icon icol32-money-euro"></span>
        <?php $sql = "SELECT id FROM auto WHERE id_status = 4";
        $result=mysqli_query($conn, $sql);
        $totale_auto_vendute=mysqli_num_rows($result);
        ?>
        <!-- Statistic Content -->
        <span class="mws-stat-content">
            <span class="mws-stat-title">Auto vendute</span>
            <span class="mws-stat-value"><?echo $totale_auto_vendute; ?></span>
        </span>
    </a>
                    
</div>

<?php } ?>