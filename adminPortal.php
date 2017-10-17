<?php include 'session_check.php' ?>
<!-- DOCTYPE -->
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Admin Portal</title>
    <meta charset="utf-8">
    <!-- Viewport Meta Tag -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="CSS/main.css">
  </head>
  <body>
    <?php include 'header.php' ?>
    <?php
      include 'DBhelper.php';
      $DBhelper = new DBhelper();

      $mysqlconn = $DBhelper->db_connect();

      //Video link
      $video_link_show = $video_path . $target_dir;//real link
    ?>

      <section>
        <!-- YOUR CONTENT GOES HERE -->
        <div class="container">
          <nav class="navbar navbar-toggleable-md navbar-light bg-faded">
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle = "collapse" data-target="#navbarTogglerMenu" aria-control="navbarTogglerMenu" aria-expanded="false" aria-label = "Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>

            <a href="#" class="navbar-brand">Dashboard</a>

            <div class="collapse navbar-collapse" id="navbarTogglerMenu">
              <!-- Nav tabs -->
              <ul id="dashboard-nav" class="nav nav-tabs mr-auto" role="tablist">
          
                <li class="nav-item">
                  <a class="nav-link" href="#upload" id="upload-tab" role="tab" data-toggle="tab" aria-controls="upload" aria-expanded="true"><?php echo $admin_menu_1 ?></a>
                </li>

                <li class="nav-item">
                  <a class="nav-link" href="#videos" role="tab" id="videos-tab" data-toggle="tab" aria-controls="videos"><?php echo $admin_menu_2 ?></a>
                </li>

                <!-- Dropdown -->
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle active" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                  <?php echo $admin_menu_3 ?>
                  </a>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="#dropdown-add" role="tab" id="dropdown-add-tab" data-toggle="tab" aria-controls="dropdown-add"><?php echo $admin_dd_item1 ?></a>
                    <a class="dropdown-item" href="#dropdown-change" role="tab" id="dropdown-change-tab" data-toggle="tab" aria-controls="dropdown-change"><?php echo $admin_dd_item2 ?></a>
                    <a class="dropdown-item" href="#dropdown-show" role="tab" id="dropdown-show-tab" data-toggle="tab" aria-controls="dropdown-show"><?php echo $admin_dd_item3 ?></a>
                  </div>
                </li>
              </ul>
                <div>
                  <button type="button" id = "admin_logout" class="btn btn-warning">Log Out</button>
                </div>
            </div>
          </nav>

        <form id="accountForm" method="post" class="form-horizontal" enctype="multipart/form-data">
          <!-- Content Panel -->
          <div id="admin-nav-content" class="tab-content">
            <?php
              if (isset($_POST['upload_admin'])) {
                # code...

                //extension
                $file_extension = pathinfo(basename($_FILES["file_upload"]["name"]), PATHINFO_EXTENSION);

                //file name
                $random_number = mt_rand();

                if (date("a") == "am"){
                  $hour = date("h");
                }else {
                  $hour = date ("h") + 12;
                }

                $upload_time = date("Y") . date("m") . date("d") . $hour . date("i") . date("s");
                $final_name = $upload_time . $random_number . "." . $file_extension;

                //Size
                $file_real_size = $_FILES['file_upload']['size'];
                $file_show_size = $DBhelper->size_format($file_real_size);

                $username = $_SESSION['login_user'];

                $record_time = $DBhelper->get_current_time();
                $client_ip = $DBhelper->get_ip();

                //echo '<script type = "text/javascript">alert("' . $file_show_size . '");</script>';
                //echo '<script type = "text/javascript">alert("' . $client_ip . '");</script>';

                if (!in_array($file_extension, $video_extensions) || $file_real_size > $file_max_size_admin){
                  echo '<script type = "text/javascript">alert("' . $main_message_1 . '");</script>';

                }else{

                  $target_file = $target_dir . $final_name;
                  //Check file name existed
                  while (file_exists($target_file)) {
                    $random_number += 1;
                    $final_name = $final_name = $upload_time . $random_number . "." . $file_extension;
                    $target_file = $target_dir. $final_name;
                  }

                  //echo '<script type = "text/javascript">alert("' . $target_file . '");</script>';

                  if (move_uploaded_file($_FILES['file_upload']['tmp_name'], $target_file)){
                    $video_link = $video_path . $target_file;

                    $video_detail = array($username, $client_ip, $record_time, $final_name, $file_show_size);

                    $insert_result = $DBhelper->video_detail_insert($mysqlconn, $video_detail);

                    if ($insert_result == 1){
                      echo '<script type = "text/javascript">alert("' . $main_message_2 . $video_link . '" );</script>';
                    }else if ($insert_result == 0){
                      echo '<script type = "text/javascript">alert("' . $main_message_3 . $video_link . '" );</script>';
                    }
                  }else{
                    echo '<script type = "text/javascript">alert("' . $main_message_4 . '");</script>';
                  }
                }
              }
            ?>
          <div role="tabpanel" class="tab-pane fade show active" id="upload" aria-labelledby="upload-tab">
            <div class="form-group">
              <h2>
              <?php echo $admin_ul_greeting ?>
              </h2>
              <hr>
              <br>
              <br>
              <div>
                <input type="file" name="file_upload" class="form-control-file">
              </div>
              <small><?php echo $admin_intro_1 ?></small>
              <br><br>
              <div>
                <input type="submit" name="upload_admin" class="btn btn-primary" value="Upload">
              </div>
            </div>  
          </div>

          <div role="tabpanel" class="tab-pane fade" id="videos" aria-labelledby="videos-tab">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th><input type="checkbox" id="select_all" />  Select All</th>
                  <th>#</th>
                  <th><?php echo $video_table_col_1; ?></th>
                  <th><?php echo $video_table_col_2; ?></th>
                  <th><?php echo $video_table_col_3; ?></th>
                  <th><?php echo $video_table_col_4; ?></th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $DBhelper -> db_show_video($mysqlconn, $video_link_show);
                ?>
              </tbody>
            </table>
            <hr>
            <br>

            <div align="right">
            	<button type = "button" id="video_delete" class="btn btn-danger">Delete</button>
            </div>
            <hr>
          </div>

          <div role="tabpanel" class="tab-pane fade" id="dropdown-add" aria-labelledby="dropdown-add-tab">
            
            <h2><?php echo $admin_add_greeting ?></h2>
            <hr>
            <div class="form-group">
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
            </div>

            <hr>
          </div>

          <div role="tabpanel" class="tab-pane fade" id="dropdown-change" aria-labelledby="dropdown-change-tab">
            
            <h2><?php echo $admin_change_greeting ?></h2>
            <hr>

            <div class="form-group">
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
            </div>

            <hr>
          </div>

          <div role="tabpanel" class="tab-pane fade" id="dropdown-show" aria-labelledby="dropdown-show-tab">
                <?php
                  $DBhelper -> refresh_account($mysqlconn, $account_table_array);
                ?>
          </div>

          </div>
        </form>
        </div>
      </section>
    <?php include 'footer.php' ?>

    <!-- JavaScript: placed at the end of the document so the pages load faster -->
    <!-- jQuery library -->
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script src="javascript/jquery.js"></script>

    <!-- Tether -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>

    <script type="text/javascript" src = "javascript/variable.js"></script>
    <script type="text/javascript" src = "javascript/adminPortal.js"></script>



    <!-- Initialize Bootstrap functionality -->
    <script>
    // Initialize tooltip component
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })

    // Initialize popover component
    $(function () {
      $('[data-toggle="popover"]').popover()
    })
    </script>
  </body>
</html>