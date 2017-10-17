<?php include 'session_check.php' ?>
<table class="table table-hover">
							<thead>
								<tr>
									<th>#</th>
									<th>Username</th>
									<th>Account Type</th>
									<th>Account Status</th>
								</tr>
							</thead>
							<tbody>
<?php
	include 'DBhelper.php';
	$DBhelper = new DBhelper();

	$mysqlconn = $DBhelper->db_connect();
	
	$sql_statement = "SELECT * FROM user";
	$mysql_result = mysqli_query($mysqlconn, $sql_statement);
	$index = 1;

	while ($sql_result = mysqli_fetch_array($mysql_result)) {
		echo "<tr>";
		echo "<th scope='row'>" . $index . "</th>";
		echo "<td>" . $sql_result['username'] . "</td>";

		if ($sql_result['admin'] == 2){
			echo "<td>Admin</td>";
		}else{
			echo "<td>Non-Admin</td>";
		}

		if ($sql_result['active'] == 1){
			echo "<td>Active</td>";
		}else{
			echo "<td>Inactive</td>";
		}

		$index += 1;

		echo "</tr>";
	}
?>
							</tbody>
						</table>