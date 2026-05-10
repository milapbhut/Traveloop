<?php
include("../includes/db.php");

$totalUsers = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users"));
$totalTrips = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM trips"));
$totalPosts = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM community_posts"));
?>