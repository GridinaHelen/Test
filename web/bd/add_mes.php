<?php
$_GET['id_postM'] = isset($_GET['id_postM']) ? $_GET['id_postM'] : '1';
$_GET['mesM'] = isset($_GET['mesM']) ? $_GET['mesM'] : ' ';

$mesM= $_GET['tx'];
$id_postM=nl2br(htmlspecialchars($_GET['id']));

  if (isset($_GET['action1'])) $do = 'newMess'; // проверяем, была ли нажата первая кнопка
  elseif (isset($_GET['action2'])) $do = 'editPost'; // или вторая
  else die('Error!!!'); // какая-то из них должна была быть нажата... значит что-то не так


$db = "blog";
$link = @mysql_connect ("localhost","root");
mysql_query("SET NAMES=cp1251");

if ( !$link )
   die ("Невозможно подключение к MySQL");
mysql_select_db ( $db ) or die ("Невозможно открыть $db");

if($do=='newMess'){
// Формируем запрос на извлечение списка сообщений соответствуюшей темы
 $resAM = mysql_query("SELECT max(id_message) FROM message;");
 $totalAM = mysql_result($resAM,0); 
 $iAM=$totalAM+1;
    

$queryAM = "INSERT INTO message
          VALUES ('$iAM','$mesM','$id_postM',NOW())";
mysql_query($queryAM);
}
if($do=='editPost'){
if (!isset($_SERVER['PHP_AUTH_USER']))
{
        Header ("WWW-Authenticate: Basic realm=\"Restricted area\"");
        Header ("HTTP/1.0 401 Unauthorized");
        exit();
}
else
{
        if (!get_magic_quotes_gpc())
        {
                $_SERVER['PHP_AUTH_USER'] = mysql_escape_string($_SERVER['PHP_AUTH_USER']);
                $_SERVER['PHP_AUTH_PW'] = mysql_escape_string($_SERVER['PHP_AUTH_PW']);
        }

        $login = $_SERVER['PHP_AUTH_USER'];
        $pass = $_SERVER['PHP_AUTH_PW'];

        if($login!='admin' OR $pass!='password')
        {
                Header ("WWW-Authenticate: Basic realm=\"Restricted area\"");
                Header ("HTTP/1.0 401 Unauthorized");
                exit();
        }
$queryAM = "UPDATE post SET name='$mesM' WHERE id_post='$id_postM'";
mysql_query($queryAM);
}
}


$id=$id_postM;
 include("mes_view.php");

?>
