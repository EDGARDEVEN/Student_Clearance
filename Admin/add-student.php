<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('../connect.php');
include('../connect2.php');

$username = $_SESSION['admin-username'];
$sql = "SELECT * FROM admin WHERE username='$username'"; 
$result = $conn->query($sql);
$row1 = mysqli_fetch_array($result);

date_default_timezone_set('Africa/Nairobi');
$current_date = date('Y-m-d H:i:s');

if(isset($_POST["btnregister"])) {

    $fullname = mysqli_real_escape_string($conn, $_POST['txtfullname']);
    $matric_no = mysqli_real_escape_string($conn, $_POST['txtmatric_no']);
    $phone = mysqli_real_escape_string($conn, $_POST['txtphone']);
    $password = mysqli_real_escape_string($conn, $_POST['txtpass']);
    $session = mysqli_real_escape_string($conn, $_POST['cmdsession']);
    $faculty = mysqli_real_escape_string($conn, $_POST['cmdfaculty']);
    $dept = mysqli_real_escape_string($conn, $_POST['cmddept']);

    $sql = "SELECT * FROM students WHERE matric_no='$matric_no'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['error'] = 'Registration No already exists';
    } else {
        // Save user's details
        $query = "INSERT INTO `students` (fullname, matric_no, password, session, faculty, dept, phone, photo, is_hostel_approved, is_sport_approved, is_stud_affairs_approved)
                  VALUES ('$fullname', '$matric_no', '$password', '$session', '$faculty', '$dept', '$phone', 'uploads/avatar_nick.png', '0', '0', '0')";

        $result = mysqli_query($conn, $query);
        if ($result) {
            $_SESSION['matric_no'] = $matric_no;
            $_SESSION['success'] = 'Student Registration was successful';
        } else {
            $_SESSION['error'] = 'Problem registering student: ' . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register Student | Dashboard</title>
  <link rel="icon" type="image/png" sizes="16x16" href="../images/favicon.png">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Home</a>
      </li>
    </ul>
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>
    <ul class="navbar-nav ml-auto"></ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="index.php" class="brand-link">
      <img src="../images/jkuat-logo.png" alt=" Logo" width="200" height="111" class="" style="opacity: .8">
      <span class="brand-text font-weight-light"></span>
    </a>
    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../<?php echo $row1['photo']; ?>" alt="User Image" width="220" height="192" class="img-circle elevation-2">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $row1['fullname']; ?></a>
        </div>
      </div>
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <?php include('sidebar.php'); ?>
        </ul>
      </nav>
    </div>
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">&nbsp;</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Register Student</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Register Student</h3>
            </div>
            <form id="form" action="" method="post" class="">
              <div class="card-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Fullname</label>
                  <input type="text" class="form-control" name="txtfullname" id="exampleInputEmail1" size="77" placeholder="Enter Fullname">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Registration No.</label>
                  <input type="text" class="form-control" name="txtmatric_no" id="exampleInputEmail1" size="77" placeholder="Enter Registration No.">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Password</label>
                  <input type="password" class="form-control" name="txtpass" id="exampleInputPassword1" size="77" placeholder="Enter Password">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Phone No.</label>
                  <input type="text" class="form-control" name="txtphone" id="exampleInputEmail1" size="77" placeholder="Enter Phone">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Session</label>
                  <select name="cmdsession" id="select" class="form-control" required="">
                    <?php
                    $sql = "SELECT * FROM tblsession";
                    $stmt = $dbh->prepare($sql);
                    $stmt->execute();
                    $sessions = $stmt->fetchAll();
                    foreach ($sessions as $row_session) {
                      echo "<option value='" . $row_session['session'] . "'>" . $row_session['session'] . "</option>";
                    }
                    ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Faculty</label>
                  <select name="cmdfaculty" id="select" class="form-control" required="">
                    <option value="Select faculty">Select faculty</option>
                    <option value="Science">Science</option>
                    <option value="Engineering">Engineering</option>
                    <option value="Social Science">Social Science</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Department</label>
                  <select name="cmddept" id="select" class="form-control" required="">
                    <option value="Select Department">Select Department</option>
                    <option value="Computer Science">Computer Science</option>
                    <option value="Electrical Engineering">Electrical Engineering</option>
                    <option value="Business Management">Business Management</option>
                    <option value="Information Technology">Information Technology</option>
                  </select>
                </div>
              </div>
              <div class="card-footer">
                <button type="submit" name="btnregister" class="btn btn-primary">Register Student</button>
              </div>
            </form>
          </div>
        </div>
        <div class="row"></div>
      </div>
    </section>
  </div>
  <footer class="main-footer">
    <?php include('../footer.php'); ?>
    <div class="float-right d-none d-sm-inline-block"></div>
  </footer>
  <aside class="control-sidebar control-sidebar-dark"></aside>
</div>

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>

<link rel="stylesheet" href="popup_style.css">
<?php if (!empty($_SESSION['success'])) { ?>
  <div class="popup popup--icon -success js_success-popup popup--visible">
    <div class="popup__background"></div>
    <div class="popup__content">
      <h3 class="popup__content__title">
        <strong>Success</strong>
      </h3>
      <p><?php echo $_SESSION['success']; ?></p>
      <p>
        <button class="button button--success" data-for="js_success-popup">Close</button>
      </p>
    </div>
  </div>
  <?php unset($_SESSION["success"]);
} ?>
<?php if (!empty($_SESSION['error'])) { ?>
  <div class="popup popup--icon -error js_error-popup popup--visible">
    <div class="popup__background"></div>
    <div class="popup__content">
      <h3 class="popup__content__title">
        <strong>Error</strong>
      </h3>
      <p><?php echo $_SESSION['error']; ?></p>
      <p>
        <button class="button button--error" data-for="js_error-popup">Close</button>
      </p>
    </div>
  </div>
  <?php unset($_SESSION["error"]);
} ?>
<script>
  var addButtonTrigger = function addButtonTrigger(el) {
    el.addEventListener('click', function () {
      var popupEl = document.querySelector('.' + el.dataset.for);
      popupEl.classList.toggle('popup--visible');
    });
  };

  Array.from(document.querySelectorAll('button[data-for]')).
  forEach(addButtonTrigger);
</script>
</body>
</html>
