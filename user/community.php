<?php
include("includes/auth.php");
include("includes/db.php");

if(isset($_POST['post']))
{
    $user_id = $_SESSION['user_id'];
    $content = $_POST['content'];

    $query = "INSERT INTO community_posts
    (user_id, content)

    VALUES

    ('$user_id','$content')";

    mysqli_query($conn, $query);
}
?>