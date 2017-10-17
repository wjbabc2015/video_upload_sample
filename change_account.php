<?php include 'session_check.php' ?>
<?php

	include 'DBhelper.php';
	$DBhelper = new DBhelper();

	$mysqlconn = $DBhelper -> db_connect();

  $username = mysqli_real_escape_string($mysqlconn, trim($_POST['username']));
  $password = mysqli_real_escape_string($mysqlconn, trim($_POST['password']));

  //echo '<script type = "text/javascript">alert("' . $username . '");</script>';

  $mysql_statement = "UPDATE user SET password ='" . $password . "' WHERE username = '" . $username . "'";

  $insert_result = mysqli_query($mysqlconn, $mysql_statement);
  if (mysql_affected_rows() != 0){
    echo '<script type = "text/javascript">alert("' . $pass_change . '");</script>';
  }else{
    echo '<script type = "text/javascript">alert("' . $pass_change_error . '");</script>';
  }

	echo '<div class="form-group">
              <label class="col-xs-3 control-label">Username</label>
              <div class="col-xs-5">
                <input type="text" name="username_change" class="form-control" id="username_change_id">
              </div>
            </div>

            <div class="form-group">
              <label class="col-xs-3 control-label">New Password</label>
              <div class="col-xs-5">
                <input type="password" name="password_change" class="form-control" id="password_change_id">
              </div>
            </div>

            <div class="form-group">
              <label class="col-xs-3 control-label">Re-enter Password</label>
              <div class="col-xs-5">
                <input type="password" name="pass_change" class="form-control" id="pass_change_id">
              </div>
            </div>

            <div class="form-group" style="margin-top: 15px;">
                  <div class="col-xs-5 col-xs-offset-3">
                      <button type="button" name = "admin_change" class="btn btn-primary" onclick="accountChange()">Submit</button>
                  </div>
            </div>';

	mysqli_close($mysqlconn);
?>