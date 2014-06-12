<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=cp1251"> 
<link href="style.css" rel="stylesheet" type="text/css" >
</head>
</html>
<?php
 // определяем начальное время
  include("D:\INTERNET\static\start_time_m.php");
  $sql_timeM=0;
function my_query($sql) 
{    
    static $count = 0; 
    if($sql == null)  return $count;
    ++$count;
    return mysql_query($sql);  
}


   $_GET['id'] = isset($_GET['id']) ? $_GET['id'] : 1;
   $id_post=$_GET["id"]; 
?>
<form action="view_search.php?" method="GET">
<input type="text" name="search" size="25" maxlength="40">
<br>
<input type="submit" name="submit" value="Искать">
</form>
<?php  
  // Устанавливаем соединение с базой данных
     include("connect_bd.php");



//определение и вывод темы
     include("D:\INTERNET\static\start_time_sql.php"); 
     $sql="select name from post where id_post=$id_post";
     $result=my_query($sql);
     include("D:\INTERNET\static\end_time_sql.php"); 
     $sql_timeM+=$time_sql; 
     $name = mysql_result($result,0);
     echo "Пост: ";
     echo $name;



// Число позиций на странице
     $pnumber = 5;

// Формируем запрос на извлечение списка сообщений
     @include("D:\INTERNET\static\start_time_sql.php"); 
     $query = "SELECT * FROM message where id_post=$id_post";
     $t = my_query($query);
     include("D:\INTERNET\static\end_time_sql.php"); 
     $sql_timeM+=$time_sql; 
     if(!$t) exit(mysql_error());

 
// Формируем запрос на извлечение списка сообщений соответствуюшей темы
    include("D:\INTERNET\static\start_time_sql.php"); 
    $query = "SELECT COUNT(*) FROM message where id_post=$id_post";
    $tot = my_query($query);
    include("D:\INTERNET\static\end_time_sql.php"); 
    $sql_timeM+=$time_sql; 
    if(!$tot) exit(mysql_error());
//определение количества сообщений
    $total = mysql_result($tot,0);

 // Число страниц    
    $number = (int)($total/$pnumber);
    if((float)($total/$pnumber) - $number != 0) $number++;

if ($total>0)
{
  //Определение id сообщения
     $_GET['id_message'] = isset($_GET['id_message']) ? $_GET['id_message'] :1;

  
   if(preg_match("|^[\d]+$|i",$_GET['id_message']))
  {
    // Проверяем, передан ли номер текущей страницы
      if(isset($_GET['page'])) $page = $_GET['page'];
      else $page = $number;

    // Начальная позиция
       $start = (($page - 1)*$pnumber );

  //Формирование запроса, на выбор сообщений из диапазона
    if ($page==$number)    
    { 
      $query = "SELECT * FROM message where id_post=$id_post
 	        LIMIT $start, $total";//$pnumber";
    }
    else
    {
     $query = "SELECT * FROM message where id_post=$id_post
 	        LIMIT $start, $pnumber";
    }
       include("D:\INTERNET\static\start_time_sql.php");   
       $prd = my_query($query);
       include("D:\INTERNET\static\end_time_sql.php"); 
       $sql_timeM+=$time_sql; 
       if(!$prd) exit(mysql_error());


    // Если для текущей страницы имеется хотя бы
    // одно сообщение, выводим его
       if(mysql_num_rows($prd) > 0)
        {
               echo "<table border=1 class='main_border'h1>
                             
                <tr>
                <td>Сообщение</td>
                <td>Дата</td>
		
                </H1>
             
              </tr> ";
          while($product = mysql_fetch_array($prd))
          { 
           //вывод ответов
             echo "
		   <tr>
                    <td>$product[mess]</td>
                    <td>".@date_rW(strtotime($product[posted]), '%DAYWEEK%, j %MONTH% Y, G:i')."</a></td>   
                   </tr>";
          }
             echo "</table>";
        }
  

    // Постраничная навигация
////////////////////////////////

     if ($number<10)
     {
      for($i = 1; $i <= $number; $i++)
      {
         if(($i != $number))
         {
           if($page == $i)
           {
             echo $i."&nbsp;";
           }
           else
             echo "<a href=$_SERVER[PHP_SELF]?id_message=".$_GET['id_message']."&page=".$i.">".$i.","."</a>&nbsp;";
         }
         else
         {
          if($page == $i)
            { echo $i."&nbsp;";}
          else
           echo "<a href=$_SERVER[PHP_SELF]?id_message=".$_GET['id_message']."&page=".$i.">".$i.","."</a>&nbsp;";
         }
      }
     }

   else 
   {
$i=1;
   echo "<a href=$_SERVER[PHP_SELF]?id_post=".$_GET['id_message']."&page=".$i.">".$i."</a>&nbsp;";

if($page<($number-5))
  {$npM=$page+1;$kpM=$page+4;}
else
  {$npM=2;$kpM=5;}
    for($i = $npM; $i <=$kpM; $i++)
      {
         if(($i != $number))
         {
           if($page == $i)
           {
             echo $i.","."&nbsp;";
           }
           else
             echo "<a href=$_SERVER[PHP_SELF]?id_message=".$_GET['id_message']."&page=".$i.">".$i.","."</a>&nbsp;";
         }
         else
         {
          if($page == $i)
            { echo $i."&nbsp;";}
          else
           echo "<a href=$_SERVER[PHP_SELF]?id_message=".$_GET['id_message']."&page=".$i.">".$i.","."</a>&nbsp;";
         }
      }
    echo "<a href=$_SERVER[PHP_SELF]?id_message=".$_GET['id_message']."&page=".$i.">"."..,"."</a>&nbsp;";
   for($i = $number-2; $i <$number; $i++)
      {
         if(($i != $number))
         {
           if($page == $i)
           {
             echo $i.","."&nbsp;";
           }
           else
             echo "<a href=$_SERVER[PHP_SELF]?id_message=".$_GET['id_message']."&page=".$i.">".$i.","."</a>&nbsp;";
         }
         else
         {
          if($page == $i)
            { echo $i."&nbsp;";}
          else
           echo "<a href=$_SERVER[PHP_SELF]?id_message=".$_GET['id_message']."&page=".$i.">".$i.","."</a>&nbsp;";
         }
      }
   }
  $i=$number;
 echo "<a href=$_SERVER[PHP_SELF]?id_message=".$_GET['id_message']."&page=".$i.">".$i."</a>&nbsp;";


}
}
else printf("\n%s\n", "Данная тема на форуме не обсуждалась");
?>

<form action="add_mes.php?" method="GET">
<textarea name="tx" cols="40" rows="5" ></textarea>
<input type="hidden" name="id" value="<?php print $id_post;?>">
<br>
<input type="submit" name="action1" value=ОтправитьСообщение>
<input type="submit" name="action2" value=РедактироватьПост>
</form>
<?php
printf("<br>");
  // определяем время генерации страницы
  include("D:\INTERNET\static\end_time_M.php");
printf("PHP: %d%%, SQL:%d %%|",($timeM-$sql_timeM)/$timeM*100,$sql_timeM/$timeM*100);
//Количество запросов SQL
echo "      SQL запросов:";
echo my_query("");
printf("     | SQL time %0.4f]",$sql_timeM); 

function date_rW($d, $format = 'j %MONTH% Y')
{
    $montharr = array('Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек');
    $dayarr = array('Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс');
 
    $d += 3600;
 
    $sarr = array('/%MONTH%/i', '/%DAYWEEK%/i');
    $rarr = array( $montharr[date("m", $d) - 1], $dayarr[date("N", $d) - 1] );
 
    $format = preg_replace($sarr, $rarr, $format); 
    return date($format, $d);
}
?>


