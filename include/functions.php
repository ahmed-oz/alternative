<?php

/*
 ** Change PHP  MySQL Functions to PHP MySQLI Functions
 ** Aj Osman
 ** 16-02-2018
 ** Build a new function to replace mysql_result()
*/


function mysqli_result($res,$row=0,$col=0){
  $numrows = mysqli_num_rows($res);
  if ($numrows && $row <= ($numrows-1) && $row >=0){
      mysqli_data_seek($res,$row);
      $resrow = (is_numeric($col)) ? mysqli_fetch_row($res) : mysqli_fetch_assoc($res);
      if (isset($resrow[$col])){
          return $resrow[$col];
      }
  }
  return false;
}

 ?>
