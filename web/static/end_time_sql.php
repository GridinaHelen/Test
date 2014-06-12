<?php 

$end_sql = microtime(); 

$end_sql = explode(" ",$end_sql); 

$end_sql = $end_sql[1] + $end_sql[0]; 

// вычитаем из конечного времени начальное 

$time_sql = $end_sql - $start_sql; 

// выводим в выходной поток (броузер) время генерации страницы 

//printf("Страница сгенерирована за %f секунд",$time_sql); 

?>
