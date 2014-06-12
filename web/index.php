<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=cp1251"> 
<link href="style.css" rel="stylesheet" type="text/css" >
</head>
</html>

<?php 

include ("bd/theme_view.php");//выводим посты

?>
 
<form action="bd/add_theme.php" method="GET"header()>
<input type="text" name="tx">
<input type="submit" name="submit" value="Добавить пост">
</form>
