<?php
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


$post= $_GET['tx'];
$db = "blog";
$link = @mysql_connect ("localhost","root");
mysql_query("SET NAMES=cp1251");

if ( !$link )
   die ("Невозможно подключение к MySQL");
mysql_select_db ( $db ) or die ("Невозможно открыть $db");


// Формируем запрос на определение количества тем
 $res = mysql_query("SELECT COUNT(*) FROM post;");
 $row = mysql_fetch_row($res);
 $total = $row[0]; // всего записей
 $i=$total+1;

 $query = "INSERT INTO post
           VALUES ('$i','$post')";
 mysql_query($query);
echo "<a href=../index.php>Вернуться на главную</a>";
}
// Disqus
$txt['disqus_settings_title'] = 'Настройки Disqus';
$txt['disqus_admin_menu'] = 'Disqus';
$txt['disqus_settings_desc'] = 'Изменение конфигурации мода Disqus';
$txt['disqus_allow'] = 'Включить систему комментариев Disqus?';
$txt['disqus_board_enable'] = 'Подключить систему комментариев Disqus';
$txt['disqus_board_enable_desc'] = '';
$txt['disqus_id'] = 'Введите здесь \'short name\' (короткое имя), которое указали при регистрации форума в Disqus.';
$txt['disqus_configure_desc'] = 'Перед подключением Disqus необходимо зарегистрироваться на сайте <a href="http://www.disqus.com" target="_blank">disqus.com</a>';

?>
