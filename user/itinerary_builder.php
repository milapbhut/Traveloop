<?php
include("includes/auth.php");
include("includes/db.php");

if(isset($_POST['add_section']))
{
    $trip_id = $_POST['trip_id'];
    $section_title = $_POST['section_title'];
    $activities = $_POST['activities'];
    $budget = $_POST['budget'];

    $query = "INSERT INTO itinerary
    (trip_id, section_title, activities, budget)

    VALUES

    ('$trip_id','$section_title','$activities','$budget')";

    mysqli_query($conn, $query);
}
?>