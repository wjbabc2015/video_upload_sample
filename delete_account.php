<?php include 'session_check.php' ?>
<?php
	$account_names = $_POST['accountName'];

	include 'DBhelper.php';
	$DBhelper = new DBhelper();

	$mysqlconn = $DBhelper -> db_connect();

	if (isset($account_names)) {
		# code...

		foreach ($account_names as $account_name) {
			# code...
			$mysql_statement = "DELETE FROM user WHERE username = '" . $account_name . "'";

			$result = mysqli_query($mysqlconn, $mysql_statement);
		}
	}

	$DBhelper->refresh_account($mysqlconn, $account_table_array);	

	mysqli_close($mysqlconn);
?>