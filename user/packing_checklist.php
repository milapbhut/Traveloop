<?php
include("includes/auth.php");
include("includes/db.php");

if(isset($_POST['add_item']))
{
    $trip_id = $_POST['trip_id'];
    $item = $_POST['item_name'];
    $category = $_POST['category'];

    $query = "INSERT INTO packing_list
    (trip_id, item_name, category)

    VALUES

    ('$trip_id','$item','$category')";

    mysqli_query($conn, $query);
}
?>