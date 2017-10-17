<?php include 'session_check.php' ?>
<?php
	$videoNames = $_POST['videoName'];

	include 'DBhelper.php';
	$DBhelper = new DBhelper();

	$mysqlconn = $DBhelper -> db_connect();

	if (isset($videoNames)) {
		foreach ($videoNames as $video_name) {
			# code...
			//echo "<script>alert('" . $video_name . "')</script>";
			if (rename($old_path . $video_name, $new_path . $video_name)) {
				# code...
				$mysql_statement = "DELETE FROM video WHERE name = '" . $video_name . "'";

				$result = mysqli_query($mysqlconn, $mysql_statement);
			}

		}
	}

	$video_link_show = $video_path . $target_dir;

	echo '<table class="table table-hover">
              <thead>
                <tr>
                  <th><input type="checkbox" id="select_all" />Select All</th>
                  <th>#</th>
                  <th>';
    echo $video_table_col_1;
    echo '</th><th>';
    echo $video_table_col_2;
    echo '</th><th>';
    echo $video_table_col_3;
    echo '</th><th>';
    echo $video_table_col_4;
    echo '</th></tr>
              </thead>
              <tbody>';

	$DBhelper -> db_show_video($mysqlconn, $video_link_show);

	echo '</tbody>
            </table>
            <hr>
            <br>

            <div align="right">
            	<button id="video_delete" class="btn btn-danger">Delete</button></div><hr>';

	mysqli_close($mysqlconn);

?>