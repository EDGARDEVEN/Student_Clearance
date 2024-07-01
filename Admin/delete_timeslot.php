<?php 
error_reporting(0);
 include('../connect2.php');

$id= $_GET['id'];        
$sql = "DELETE FROM timeslots WHERE ID=?";
$stmt= $dbh->prepare($sql);
$stmt->execute([$id]);

header("Location: admin_timeslots.php"); 
 ?>