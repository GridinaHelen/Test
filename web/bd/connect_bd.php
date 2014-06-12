<?php
$db = "blog";
$link = @mysql_connect ("localhost","root");
mysql_query("SET NAMES=cp1251");

   if ( !$link )
   die ("Невозможно подключение к MySQL");
mysql_select_db ( $db ) or die ("Невозможно открыть $db");
   
?>
