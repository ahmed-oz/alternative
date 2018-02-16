<?php
/*
 ** Change PHP  MySQL Functions to PHP MySQLI Functions
 ** Aj Osman
 ** 16-02-2018
*/

error_reporting(-1);
date_default_timezone_set('Europe/Rome');
ob_start();
$db = 'bpmjqedmtx';
$host = '174.138.11.50';
/* Modificato da Gianluca - 20170111 */
$username = 'bpmjqedmtx';
$password = '96DEGudhh2';
if (!($conn = @(count($t_yakpro_mtm_tmp = explode(':', $host)) > 1 ? mysqli_connect($t_yakpro_mtm_tmp[0], $username, $password, '', $t_yakpro_mtm_tmp[1]) : mysqli_connect($host, $username, $password)))) {
    echo 'Impossibile connettersi a MySql<br>';
    echo mysqli_errno($conn) . ': ' . mysqli_error($conn) . '
';
    die;
}
if (!@mysqli_select_db($conn, $db)) {
    echo "Impossibile selezionare il database {$db}";
    echo mysqli_errno($conn) . ': ' . mysqli_error($conn) . '
';
    die;
}
mysqli_query($conn, 'SET character_set_client = \'utf8\'');
mysqli_query($conn, 'SET character_set_results = \'utf8\'');
mysqli_query($conn, 'SET character_set_connection = \'utf8\'');
/*mysql_query("SET NAMES 'utf8'");*/
function goToPage($url)
{
    //echo "<script>window.location.replace('".$url."');</script>";
    echo '<script>window.location.href=\'' . $url . '\';</script>';
    die;
}
function debug($s, $p = 1)
{
    echo '<pre>';
    var_dump($s);
    echo '</pre>';
    if ($p) {
        die;
    }
}
function clear_data_blocco_fine()
{
}
function isValidDateTime($dateTime)
{
    if (preg_match('/^(\\d{4})-(\\d{2})-(\\d{2}) ([01][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/', $dateTime, $matches)) {
        if (checkdate($matches[2], $matches[3], $matches[1])) {
            return true;
        }
    }
    return false;
}
?>
