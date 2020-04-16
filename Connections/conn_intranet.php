<?php
 $hostname_conn_intranet = "";
 $database_conn_intranet = "";
 $username_conn_intranet = "";
 $password_conn_intranet = "";
 $conn_intranet = mysqli_connect($hostname_conn_intranet, $username_conn_intranet, $password_conn_intranet) or die(mysqli_error());
 mysqli_set_charset($conn_intranet, 'utf8mb4');

?>