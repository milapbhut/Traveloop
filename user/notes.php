<?php
include("includes/auth.php");
include("includes/db.php");

if(isset($_POST['save_note']))
{
    $trip_id = $_POST['trip_id'];
    $note = $_POST['note'];

    $query = "INSERT INTO notes
    (trip_id, note_text)

    VALUES

    ('$trip_id','$note')";

    mysqli_query($conn, $query);
}
?>