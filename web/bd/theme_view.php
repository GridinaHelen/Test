<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=cp1251"> 
<link href="style.css" rel="stylesheet" type="text/css" >
</head>
</html>
<?php
 // определяем начальное время
 include("static\start_time.php"); 
  $sql_time=0;
 //include('date_rus.php'); 

 function my_query($sql) 
 {    
    static $count = 0; 
    if($sql == null)  return $count;
    ++$count;
    return mysql_query($sql);  
 }
  
 // Число позиций на странице
  $pnumberpost = 8;


  // Устанавливаем соединение с базой данных
  include("connect_bd.php");

//////////////////////////////////////////////////////
 // Число страниц 
    $query = "SELECT COUNT(*) FROM post ";
    include("static\start_time_sql.php"); 
    $tot = my_query($query);
  include("static\end_time_sql.php"); 
   $sql_time+=$time_sql; 
    if(!$tot) exit(mysql_error());
    $total = mysql_result($tot,0);
    $numberpost = (int)($total/$pnumberpost);
/////////////////////////////////////////////////////


  // Формируем запрос на извлечение списка
  // тем
  $query = "SELECT * FROM post ";
  include("static\start_time_sql.php"); 
  $t = my_query($query);
  include("static\end_time_sql.php"); 
   $sql_time+=$time_sql; 
  if(!$t) exit(mysql_error());

  //проверяем инициализацию id_post  
  $_GET['id_post'] = isset($_GET['id_post']) ? $_GET['id_post'] : '1';
  
   if(preg_match("|^[\d]+$|i",$_GET['id_post']))
   {
    // Проверяем, передан ли номер текущей страницы
    if(isset($_GET['pageT'])) $pageT = $_GET['pageT'];
    else $pageT = 1;


    // Начальная позиция
    $start = (($pageT - 1)*$pnumberpost );

   //Формирование запроса, на выбор тем из диапазона
    $query = "SELECT * FROM post ORDER BY id_post DESC
 	      LIMIT $start, $pnumberpost ";
    include("static\start_time_sql.php"); 
    $prd = my_query($query);
    include("static\end_time_sql.php"); 
    $sql_time+=$time_sql; 
    if(!$prd) exit(mysql_error());

    // Если для текущей страницы имеется хотя бы
    // одна тема, выводим ее
    if(mysql_num_rows($prd) > 0)
    {
      echo "<table border=1 class='main_border'h1>
               
                <tr><H1><I>
                <td>Список постов</td>
          
                </I></H1>
             
              </tr> ";

      while($product = mysql_fetch_array($prd))
      { 


     //определение количества сообщений
    // $view = "(".mysql_result($totv,0).")";
     @$num=$product[id_post];
     include("page_count.php");
     $pag=foo ($pageM);
        echo "
             <tr>
             <td><a href=bd/mes_view.php?id=$product[id_post]>$product[name]</a>              
             </tr>";
      }

      echo "</table>";
    }

   
    if((float)($total/$pnumberpost) - $numberpost != 0) $numberpost++;
   
    // Постраничная навигация

   $i=1;
   echo "<a href=$_SERVER[PHP_SELF]?id_post=".$_GET['id_post']."&pageT=".$i.">".$i."</a>&nbsp;";

 if ($numberpost<10)
  {
   for($i = 2; $i <= $numberpost; $i++)
    {
      if(($i != $numberpost))
       {
        if($pageT == $i)
         {
         echo $i."&nbsp;";
         }
        else
         echo "<a href=$_SERVER[PHP_SELF]?id_post=".$_GET['id_post']."&pageT=".$i.">".$i."</a>&nbsp;";
       }
      else
      {
        if($pageT == $i)
         echo $i."&nbsp;";
        else
        echo "<a href=$_SERVER[PHP_SELF]?id_post=".$_GET['id_post']."&pageT=".$i.">".$i."</a>&nbsp;";

      }
    }
  }
else
{
if($pageT<($numberpost-5))
  {$np=$pageT+1;$kp=$pageT+5;}
else
  {$np=$numberpost-8;$kp=$numberpost-3;}
for($i = $np; $i < $kp; $i++)
    {
    if(($i != $numberpost))
      {
        if($pageT == $i)
         {
        echo $i."&nbsp;";
         }
        else
       echo "<a href=$_SERVER[PHP_SELF]?id_post=".$_GET['id_post']."&pageT=".$i.">".$i."</a>&nbsp;";
      }
      else
      {
        if($pageT == $i)
         echo $i."&nbsp;";
        else
        echo "<a href=$_SERVER[PHP_SELF]?id_post=".$_GET['id_post']."&pageT=".$i.">".$i."</a>&nbsp;";

      }
    }

 echo "<a href=$_SERVER[PHP_SELF]?id_post=".$_GET['id_post']."&pageT=".$i.">"."..."."</a>&nbsp;";

for($i = $numberpost-3; $i <= $numberpost; $i++)
    {
    if(($i != $numberpost))
      {
        if($pageT == $i)
         {
        echo $i."&nbsp;";
         }
        else
       echo "<a href=$_SERVER[PHP_SELF]?id_post=".$_GET['id_post']."&pageT=".$i.">".$i."</a>&nbsp;";
      }
      else
      {
        if($pageT == $i)
         echo $i."&nbsp;";
        else
        echo "<a href=$_SERVER[PHP_SELF]?id_post=".$_GET['id_post']."&pageT=".$i.">".$i."</a>&nbsp;";

      }
    }
}
  }



function foo ($in)
{
 $pag="";
 if($in<10)
 {
  for($i=1;$i<$in;$i++)
   {
    $pag=$pag.$i;
    $pag=$pag.",";

   }
  $pag=$pag.$in;
 }
 else
 {
  for($i=1;$i<=5;$i++)
   {
    $pag=$pag.$i;
    $pag=$pag.",";
   };
  $pag=$pag."..,";
  for($i=$in-3;$i<$in;$i++)
   {
    $pag=$pag.$i;
    $pag=$pag.",";
   }
  $pag=$pag.$in;
 }
 return($pag);
}

      


printf("<br>");
  // определяем время генерации страницы
  include("static\end_time.php");
printf("PHP: %d%%, SQL:%d %%|",($time-$sql_time)/$time*100,$sql_time/$time*100);
//Количество запросов SQL
echo "      SQL запросов:";
echo my_query("");
printf("     | SQL time %0.4f]",$sql_time); 


function date_r($d, $format = 'j %MONTH% Y')
{
    if($d){
    $montharr = array('Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек');
    $dayarr = array('Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс');
 
    $d += 3600;
 
    $sarr = array('/%MONTH%/i', '/%DAYWEEK%/i');
    $rarr = array( $montharr[date("m", $d) - 1], $dayarr[date("N", $d) - 1] );
 
    $format = preg_replace($sarr, $rarr, $format); 

    return date($format, $d);
}
  else 
   return("Данная тема не обсуждалась");
}
	
?>
