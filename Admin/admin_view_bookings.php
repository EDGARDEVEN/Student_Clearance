<?php
session_start();
error_reporting(0);
include('../connect.php');

if (strlen($_SESSION['admin-username']) == "") {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['admin-username'];
date_default_timezone_set('Africa/Nairobi');
$current_date = date('Y-m-d H:i:s');

$sql = "select * from admin where username='$username'";
$result = $conn->query($sql);
$row1 = mysqli_fetch_array($result);

$sql = "SELECT * FROM bookings";
$bookings = $conn->query($sql);
$sql = "SELECT t.id, t.session_date, t.start_time, t.end_time, t.max_students, COUNT(b.id) as bookings_count
        FROM timeslots t
        LEFT JOIN bookings b ON t.id = b.timeslot_id
        GROUP BY t.id";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard | View Bookings</title>
    <link rel="icon" type="image/png" sizes="16x16" href="../images/favicon.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

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
    </nav>

    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="index.php" class="brand-link">
            <img src="../images/jkuat-logo.png" alt="Logo" width="200" height="111" class="" style="opacity: .8">
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

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">View Bookings</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">View Bookings</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Bookings List</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Session Date</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Max Students</th>
                                        <th>Bookings</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $result->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?php echo $row['session_date']; ?></td>
                                        <td><?php echo $row['start_time']; ?></td>
                                        <td><?php echo $row['end_time']; ?></td>
                                        <td><?php echo $row['max_students']; ?></td>
                                        <td><?php echo $row['bookings_count']; ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <?php if(!empty($_SESSION['success'])) { ?>
                <div class="popup popup--icon -success js_success-popup popup--visible">
                    <div class="popup__background"></div>
                    <div class="popup__content">
                        <h3 class="popup__content__title"><strong>Success</strong></h3>
                        <p><?php echo $_SESSION['success']; ?></p>
                        <p>
                            <button class="button button--success" data-for="js_success-popup">Close</button>
                        </p>
                    </div>
                </div>
                <?php unset($_SESSION["success"]); } ?>

                <?php if(!empty($_SESSION['error'])) { ?>
                <div class="popup popup--icon -error js_error-popup popup--visible">
                    <div class="popup__background"></div>
                    <div class="popup__content">
                        <h3 class="popup__content__title"><strong>Error</strong></h3>
                        <p><?php echo $_SESSION['error']; ?></p>
                        <p>
                            <button class="button button--error" data-for="js_error-popup">Close</button>
                        </p>
                    </div>
                </div>
                <?php unset($_SESSION["error"]); } ?>

                <script>
                var addButtonTrigger = function addButtonTrigger(el) {
                    el.addEventListener('click', function () {
                        var popupEl = document.querySelector('.' + el.dataset.for);
                        popupEl.classList.toggle('popup--visible');
                    });
                };

                Array.from(document.querySelectorAll('button[data-for]')).forEach(addButtonTrigger);
                </script>

            </div>
        </section>
    </div>

    <footer class="main-footer">
        <?php include('../footer.php'); ?>
        <div class="float-right d-none d-sm-inline-block"></div>
    </footer>

    <aside class="control-sidebar control-sidebar-dark"></aside>
</div>

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="plugins/chart.js/Chart.min.js"></script>
<script src="plugins/sparklines/sparkline.js"></script>
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="dist/js/adminlte.js"></script>
<script src="dist/js/demo.js"></script>
<script src="dist/js/pages/dashboard.js"></script>
</body>
</html>
