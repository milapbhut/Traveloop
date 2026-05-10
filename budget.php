<?php
include("includes/auth.php");
include("includes/db.php");

$trip_id = $_GET['trip_id'];

$query = "SELECT SUM(budget) AS total_budget
FROM itinerary
WHERE trip_id='$trip_id'";

$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);
?>