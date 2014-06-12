<?php 

$end_timeM = microtime(); 

$end_arrayM = explode(" ",$end_timeM); 

$end_timeM = $end_arrayM[1] + $end_arrayM[0]; 

// вычитаем из конечного времени начальное 

$timeM = $end_timeM - $start_timeM; 

// выводим в выходной поток (броузер) время генерации страницы 

printf("[Time: %0.4f s|",$timeM); 

?>
