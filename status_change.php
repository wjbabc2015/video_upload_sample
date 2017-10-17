<?php include 'session_check.php' ?>



<?php
	$key = $_POST['username'];

	include 'DBhelper.php';
	$DBhelper = new DBhelper();

	$mysqlconn = $DBhelper -> db_connect();

	$mysql_statement = "SELECT active FROM user WHERE username = '" . $key . "'";

	$result = mysqli_query($mysqlconn, $mysql_statement);

	if($row = mysqli_fetch_array($result)){
		$user_status = $row['active'];
	}

	//echo "<script>alert('" . $key . "')</script>";

	if ($user_status == 1){
		$user_status = 0;
	}else{
		$user_status = 1;
	}

	$mysql_statement = "UPDATE user SET active=" . $user_status ." WHERE username = '" . $key . "'";

	$result = mysqli_query($mysqlconn, $mysql_statement);

	$DBhelper->refresh_account($mysqlconn, $account_table_array);

	mysqli_close($mysqlconn);
?>