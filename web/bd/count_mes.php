<?php
 $query1=SELECT COUNT(*) FROM message WHERE id_post=$product[id_post]
     $prd1 = mysql_query($query1);
    if(!$prd1) exit(mysql_error());
     $total=mysql_result(!$prd1,0);
?>
