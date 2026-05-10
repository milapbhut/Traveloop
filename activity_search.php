<?php
include("includes/auth.php");
include("includes/db.php");

$query = "SELECT * FROM activities";
$result = mysqli_query($conn, $query);
?>