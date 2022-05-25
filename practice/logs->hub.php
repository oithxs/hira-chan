<?php

$logs  = DB::connection('mysql_keijiban')->select("SELECT * FROM access_logs WHERE thread_id ='$thread_id'");
$count = mysqli_num_rows($logs);


?>