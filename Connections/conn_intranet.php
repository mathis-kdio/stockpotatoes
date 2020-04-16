<?PHP
 $hostname_conn_intranet = "localhost";
 $database_conn_intranet = "stockpotatoes";
 $username_conn_intranet = "root";
 $password_conn_intranet = "";
 $conn_intranet = mysql_pconnect($hostname_conn_intranet, $username_conn_intranet, $password_conn_intranet) or die(mysql_error());

?>