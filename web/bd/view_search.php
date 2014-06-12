<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=cp1251"> 
<link href="style.css" rel="stylesheet" type="text/css" >
</head>
</html>
<?php
   $_GET['id'] = isset($_GET['id']) ? $_GET['id'] : 1;
   $id_post=$_GET["id"]; 
   
  // Устанавливаем соединение с базой данных
     include("connect_bd.php");


if (isset($_GET['submit_s']))
 {
 $submit_s = $_GET['submit_s'];
 }
 
 if (isset($_GET['search']))
 {
 $search = $_GET['search'];
 }
 
 if (isset($submit_s))
 {
 
 if (empty($search) or strlen($search) < 3)
 {
 exit ("<p>Поисковый запрос не введен, либо он менее 3-х символов.</p>");
 }
 
 $search = trim($search);
 $search = stripslashes($search);
 $search = htmlspecialchars($search);
 
 }


  // Число позиций на странице
     $countNumb = 5;


    //определение количества сообщений
    $count =mysql_result( mysql_query("SELECT count(*) FROM message WHERE mess LIKE '%$search%'"),0);

   // Число страниц    
    $show_page = (int)($count/$countNumb);
    if((float)($count/$countNumb) - $show_page != 0) $show_page++;

    $i=0;  

    if ($count>0)
    {
     echo "Результы поиска";
     //Определение id сообщения
     $_GET['id_message'] = isset($_GET['id_message']) ? $_GET['id_message'] :1;

      if(preg_match("|^[\d]+$|i",$_GET['id_message']))
      {
       // Проверяем, передан ли номер текущей страницы
         if(isset($_GET['page'])) $page = $_GET['page'];
          else $page = $show_page;
  
       // Начальная позиция
          $start = (($page - 1)*$countNumb );
  
       //Формирование запроса, на выбор сообщений из диапазона
         if ($page==$show_page)    
          {
           $query = "SELECT * FROM message where mess LIKE '%$search%' 
 	              LIMIT $start, $count";
          }
         else
          {
           $query = "SELECT * FROM message where mess LIKE '%$search%' 
 	              LIMIT $start, $countNumb";
          }


      $prd = mysql_query($query);
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
          while($myrowS = mysql_fetch_array($prd))
          { 
           //вывод ответов
             echo "
		   <tr>
                    <td>$myrowS[mess]</td>
                    <td>".@date_rS(strtotime($myrowS[posted]), '%DAYWEEK%, j %MONTH% Y, G:i')."</a></td>   
                   </tr>";
          }
             echo "</table>";
        }
      

  // Постраничная навигация
////////////////////////////////

     if ($show_page<10)
     {
      for($i = 1; $i <= $show_page; $i++)
      {
         if(($i != $show_page))
         {
           if($page == $i)
           {
             echo $i."&nbsp;";
           }
           else
             echo "<a href=$_SERVER[PHP_SELF]?search=".$search."&page=".$i.">".$i.","."</a>&nbsp;";
         }
         else
         {
          if($page == $i)
            { echo $i."&nbsp;";}
          else
           echo "<a href=$_SERVER[PHP_SELF]?search=".$search."&page=".$i.">".$i.","."</a>&nbsp;";
         }
      }
     }

   else 
   {
    $i=1;
     echo "<a href=$_SERVER[PHP_SELF]?search=".$search."&page=".$i.">".$i.","."</a>&nbsp;";

    if($page<($show_page-5))
    {
      $npM=$page+1;
      $kpM=$page+4;
    }
   else
    {$npM=2;$kpM=5;}
    for($i = $npM; $i <=$kpM; $i++)
      {
         if(($i != $show_page))
         {
           if($page == $i)
           {
             echo $i.","."&nbsp;";
           }
           else
             echo "<a href=$_SERVER[PHP_SELF]?search=".$search."&page=".$i.">".$i.","."</a>&nbsp;";
         }
         else
         {
          if($page == $i)
            { echo $i."&nbsp;";}
          else
           echo "<a href=$_SERVER[PHP_SELF]?search=".$search."&page=".$i.">".$i.","."</a>&nbsp;";
         }
      }
    echo "<a href=".$search."&page=".$i.">"."..,"."</a>&nbsp;";
   for($i = $show_page-2; $i <$show_page; $i++)
      {
         if(($i != $show_page))
         {
           if($page == $i)
           {
             echo $i.","."&nbsp;";
           }
           else
             echo "<a href=$_SERVER[PHP_SELF]?search=".$search."&page=".$i.">".$i.","."</a>&nbsp;";
         }
         else
         {
          if($page == $i)
            { echo $i."&nbsp;";}
          else
           echo "<a href=$_SERVER[PHP_SELF]?search=".$search."&page=".$i.">".$i.","."</a>&nbsp;";
         }
      
   }
 echo "<a href=$_SERVER[PHP_SELF]?search=".$search."&page=".$i.">".$i."</a>&nbsp;";

}
}


else
{
echo "Поиск не дал результата";
}
}
 echo "<a href=../index.php>Вернуться на главную</a>";
function date_rS($d, $format = 'j %MONTH% Y')
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
