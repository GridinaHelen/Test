<?php
// считываем текущее время 

$start_timeM = microtime(); 

// разделяем секунды и миллисекунды (становятся значениями начальных ключей массива-списка) 

$start_arrayM = explode(" ",$start_timeM); 

// это и есть стартовое время 

$start_timeM = $start_arrayM[1] + $start_arrayM[0];
?>
