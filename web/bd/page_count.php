<?php 

// Число позиций на странице
  $pnumber = 5;
// Устанавливаем соединение с базой данных
   include("connect_bd.php");

// Формируем запрос на извлечение списка сообщений соответствуюшей темы
   $query = "SELECT COUNT(*) FROM message where id_post=$num";
   $tot = mysql_query($query);
   if(!$tot) exit(mysql_error());
//определение количества сообщений
   $total = mysql_result($tot,0);
 // Число страниц    
   $pageM = (int)($total/$pnumber);
   if((float)($total/$pnumber) - $pageM != 0) $pageM++;
//echo $number;
?>
