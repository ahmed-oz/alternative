<div id="mws-header" class="clearfix"> 
    	<!-- Logo Container -->
    	<div id="mws-logo-container">
        
        	<!-- Logo Wrapper, images put within this wrapper will always be vertically centered -->
        	<div id="mws-logo-wrap">
            	<img src="images/alternativa-logo-header.png" alt="mws admin" />
			</div>
        </div>
        
        <!-- User Tools (notifications, logout, profile, change password) -->
        <div id="mws-user-tools" class="clearfix">
            <?php
            if ($_SESSION['tipo_sessione'] == 0) {
                $carrello = 0;
                if (isset($_SESSION['carrello_sessione'])) {
                    $carrello = count($_SESSION['carrello_sessione']);
                }
                ?>
                <a class="cart-link" href="gestione_carrello.php"><i class="icon-shopping-cart"></i> Carrello (<span id="carrello"><?php echo $carrello; ?></span>)</a>
            <?php
            }
            ?>
        	<!-- Notifications
        	<div id="mws-user-notif" class="mws-dropdown-menu">
            	<a href="#" data-toggle="dropdown" class="mws-dropdown-trigger"><i class="icon-exclamation-sign"></i></a>
                

                <span class="mws-dropdown-notif">35</span>


                <div class="mws-dropdown-box">
                	<div class="mws-dropdown-content">
                        <ul class="mws-notifications">
                        	<li class="read">
                            	<a href="#">
                                    <span class="message">
                                        Lorem ipsum dolor sit amet consectetur adipiscing elit, et al commore
                                    </span>
                                    <span class="time">
                                        January 21, 2012
                                    </span>
                                </a>
                            </li>
                        	<li class="read">
                            	<a href="#">
                                    <span class="message">
                                        Lorem ipsum dolor sit amet
                                    </span>
                                    <span class="time">
                                        January 21, 2012
                                    </span>
                                </a>
                            </li>
                        	<li class="unread">
                            	<a href="#">
                                    <span class="message">
                                        Lorem ipsum dolor sit amet
                                    </span>
                                    <span class="time">
                                        January 21, 2012
                                    </span>
                                </a>
                            </li>
                        	<li class="unread">
                            	<a href="#">
                                    <span class="message">
                                        Lorem ipsum dolor sit amet
                                    </span>
                                    <span class="time">
                                        January 21, 2012
                                    </span>
                                </a>
                            </li>
                        </ul>
                        <div class="mws-dropdown-viewall">
	                        <a href="#">View All Notifications</a>
                        </div>
                    </div>
                </div>
            </div>
            -->

            <!-- User Information and functions section -->
            <div id="mws-user-info" class="mws-inset">
            
            	<!-- User Photo -->
				<!--
            	<div id="mws-user-photo">
                	<img src="example/profile.jpg" alt="User Photo" />
                </div>-->
                
                <!-- Username and Functions -->
                <div id="mws-user-functions" style="margin-left:4px;">
                    <div id="mws-username">
                        Ciao, 	<?php echo $_SESSION['nome_concessionaria_sessione'];?>
<?php
// var_dump($_SESSION);
?>
                    </div>
                    <ul>
                        <li><a href="view_profile.php">Profilo</a></li>
                        <li><a href="change_password.php">Cambia Password</a></li>
                        <li><a href="?logout=1">Esci</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>