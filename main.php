<?php session_start();
      include 'variableConlection.php'; ?>
<!-- DOCTYPE -->
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Video Upload</title>
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
      ?>
      <section>
        <!-- YOUR CONTENT GOES HERE -->
        <div class="container">
          <nav class="navbar navbar-toggleable-md navbar-light bg-faded">
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarTogglerUpload" aria-controls="navbarTogglerUpload" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="#">Menu</a>

            <div class="collapse navbar-collapse" id="navbarTogglerUpload">
              <!-- Nav tabs -->
              <ul class="nav nav-tabs" role = "tablist">
                <li class="nav-item">
                  <a href="#video" class="nav-link active" data-toggle="tab" role = "tab">Video Upload</a>
                </li>

                <li class="nav-item">
                  <a href="#admin_login" class="nav-link" data-toggle="tab" role ="tab">Admin Login</a>
                </li>
              </ul>
            </div>
          </nav>

          <?php
            if (isset($_POST['file_submit'])) {
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

              $username = $_POST['username_upload'];
              $password = $_POST['password_upload'];

              $record_time = $DBhelper->get_current_time();
              $client_ip = $DBhelper->get_ip();

              //echo '<script type = "text/javascript">alert("' . $record_time . '");</script>';
              //echo '<script type = "text/javascript">alert("' . $client_ip . '");</script>';

              if ($DBhelper->db_login($username, $password, $mysqlconn) == 1 || $DBhelper->db_login($username, $password, $mysqlconn) == 2){

                if (!in_array($file_extension, $video_extensions) || $file_real_size > $file_max_size){
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
              }else{
                echo '<script type = "text/javascript">alert("' . $main_message_5 . '");</script>';
              }
            }
          ?>
          <form id="contentForm" method="post" class="form-horizontal" enctype="multipart/form-data">
            <!-- Tab panes -->
            <div class="tab-content">
              <div class="tab-pane active" id="video" role="tabpanel">
                <h2><?php echo $main_ul_greeting; ?></h2>
                <br><br>
                <div class="form-group">
                  <label class="col-4 control-label">Username</label>
                  <div class="col-4">
                    <input type="text" name="username_upload" class="form-control">
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-4 control-label">Password</label>
                  <div class="col-4">
                    <input type="password" name="password_upload" class="form-control">
                  </div>
                </div>

                <div class="form-group">
                  <div>
                    <input type="file" name="file_upload" class="form-control-file">
                  </div>
                  <small><?php echo $main_intro_1?></small>
                  <br><br>
                  <div>
                    <input type="submit" name="file_submit" class="btn btn-primary" value="Upload">
                  </div>
                </div>
              </div>

              <?php
                if (isset($_POST['login_submit'])) {
                  # code...
                  $username = $_POST['username_login'];
                  $password = $_POST['password_login'];

                  if ($DBhelper->db_login($username, $password, $mysqlconn) == 2){
                    $_SESSION['login_key'] = 'adminLogin';
                    $_SESSION['login_user'] = $username;
                    header('Location: adminPortal.php');
                  }else{
                    echo '<script type = "text/javascript">alert("' . $main_message_5 . '");</script>';
                  }
                }
              ?>
              <div class="tab-pane" id="admin_login" role="tabpanel">
                <h2><?php echo $main_lg_greeting; ?></h2>
                <br><br>
                <div class="form-group">
                  <label class="col-4 control-label">Username</label>
                  <div class="col-4">
                    <input type="text" name="username_login" class="form-control">
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-4 control-label">Password</label>
                  <div class="col-4">
                    <input type="password" name="password_login" class="form-control">
                  </div>
                </div>

                <div class="form-group">
                  <div>
                    <input type="submit" name="login_submit" class="btn btn-primary" value="Login">
                  </div>
                </div>
              </div>
            </div>
          </form>                   
        </div>
      </section>
      <?php include 'footer.php' ?>

    <!-- JavaScript: placed at the end of the document so the pages load faster -->
    <!-- jQuery library -->
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>

    <!-- Tether -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>

    <script type="text/javascript" src = "javascript/variable.js"></script>
    <script type="text/javascript" src = "javascript/main.js"></script>




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