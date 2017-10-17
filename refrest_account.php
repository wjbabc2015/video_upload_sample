<?php include 'session_check.php' ?>
<?php

	include 'DBhelper.php';
	$DBhelper = new DBhelper();

	$mysqlconn = $DBhelper -> db_connect();

  	$DBhelper -> refresh_account($mysqlconn, $account_table_array);

	mysqli_close($mysqlconn);
?>