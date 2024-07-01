<?php
session_start();
error_reporting(0);
include('connect.php');
if(empty($_SESSION['matric_no']))
    {   
    header("Location: login.php"); 
    }
    else{
	}
	
$ID = $_SESSION["ID"];
$matric_no = $_SESSION["matric_no"];

$sql = "select * from students where matric_no='$matric_no'"; 
$result = $conn->query($sql);
$rowaccess = mysqli_fetch_array($result);

$sql = "SELECT t.session_date, t.start_time, t.end_time 
        FROM bookings b 
        JOIN timeslots t ON b.timeslot_id = t.id 
        WHERE b.matric_no = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $matric_no);
$stmt->execute();
$result = $stmt->get_result();


date_default_timezone_set('Africa/Nairobi');
$current_date = date('Y-m-d H:i:s');

?>

<!DOCTYPE html>
<html>
<head>
    <title>Clearance Session Timeslot Ticket | JKUAT</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">  
    <link rel="stylesheet" type="text/css" href="css/print.css" media="print">
    <style>
        /* General Styles */
        body { font-family: sans-serif; }
        .container { width: 800px; margin: 0 auto; padding: 20px; }
        h1 { text-align: center; margin-bottom: 20px; }

        /* Table Styles */
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; }
        .table th { background-color: #f2f2f2; text-align: left; }

        /* Print Styles (in print.css) */
        @media print {
            /* Hide elements not needed in print, adjust layout, etc. */
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>JKUAT Clearance Session Timeslot Ticket</h1>

        <div class="student-info">
            <h2>Student Details</h2>
            <p><strong>Current Date:</strong> <?php echo $current_date; ?></p>
            <p><strong>Full Name:</strong> <?php echo $rowaccess['fullname']; ?></p>
            <p><strong>Admission Number:</strong> <?php echo $rowaccess['matric_no']; ?></p>
            <p><strong>Faculty:</strong> <?php echo $rowaccess['faculty']; ?></p>
            <p><strong>Department:</strong> <?php echo $rowaccess['dept']; ?></p>
        </div>
        <div class="student-info">
            <h2>Details</h2>
            <p>You are required to have this Ticket in order to gain entry at the session venue</p>
        </div>

        <div class="booking-info">
            <h2>Booked Clearance Sessions</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Session Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['session_date']; ?></td>
                            <td><?php echo $row['start_time']; ?></td>
                            <td><?php echo $row['end_time']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="signature">
            <p style="text-align: right;">Signed,</p>
            <p style="text-align: right;">Registrar</p>
        </div>

        <div class="print-button">
            <button onclick="window.print()">Print Ticket</button>
        </div>
    </div>

    </body>
</html>