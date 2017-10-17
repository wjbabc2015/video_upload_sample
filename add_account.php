<?php include 'session_check.php' ?>
<?php

	include 'DBhelper.php';
	$DBhelper = new DBhelper();

	$mysqlconn = $DBhelper -> db_connect();

  $username = mysqli_real_escape_string($mysqlconn, trim($_POST['username']));
  $password = mysqli_real_escape_string($mysqlconn, trim($_POST['password']));
  $adminCheck = $_POST['admin'];

  //echo '<script type = "text/javascript">alert("' . $username . '");</script>';

  $mysql_statement = "INSERT INTO user(username, password, admin, active) VALUES ('$username', '$password', '$adminCheck', '1')";

  $insert_result = mysqli_query($mysqlconn, $mysql_statement);
  if ($insert_result){
    echo '<script type = "text/javascript">alert("' . $add_successfully . '");</script>';
  }else{
    echo '<script type = "text/javascript">alert("' . $account_exist . '");</script>';
  }

	echo '<div class="form-group">
            <label class="col-xs-3 control-label">Username</label>
            <div class="col-xs-5">
              <input type="text" name="username_add" class="form-control" id="username_add_id">
            </div>
          </div>

          <div class="form-group">
            <label class="col-xs-3 control-label">Password</label>
            <div class="col-xs-5">
              <input type="password" name="password_add" class="form-control" id="password_add_id">
            </div>
          </div>

          <div class="form-group">
            <label class="col-xs-3 control-label">Re-enter Password</label>
            <div class="col-xs-5">
              <input type="password" name="pass_add" class="form-control" id="pass_add_id">
            </div>
          </div>

          <div class="form-check">
            <label class="form-check-label">
              <input type="checkbox" name="admin_check" class="form-check-input" id="admin_check_id">
              This is Admin account
            </label>
          </div>

          <div class="form-group" style="margin-top: 15px;">
                <div class="col-xs-5 col-xs-offset-3">
                    <button type="button" class="btn btn-primary" onclick="accountAdd()">Create</button>
                </div>
          </div>';

	mysqli_close($mysqlconn);
?>