<?php
session_start();

include("includes/db.php");

if(!isset($_SESSION['user_id']))
{
    header("Location: login.php");
}

$user_id = $_SESSION['user_id'];

// FETCH USER
$userQuery = "SELECT * FROM users WHERE id='$user_id'";
$userResult = mysqli_query($conn, $userQuery);
$user = mysqli_fetch_assoc($userResult);

// FETCH TRIPS
$tripQuery = "SELECT * FROM trips WHERE user_id='$user_id' ORDER BY id DESC";
$tripResult = mysqli_query($conn, $tripQuery);

?>

<!DOCTYPE html>
<html>
<head>

    <title>Traveloop Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            background:#efefef;
            font-family:Arial;
        }

        .main-container{

            width:90%;
            margin:30px auto;
            background:white;
            border-radius:15px;
            border:2px solid #ccc;
            overflow:hidden;

        }

        /* NAVBAR */

        .navbar-custom{

            height:70px;
            border-bottom:2px solid #ccc;
            display:flex;
            justify-content:space-between;
            align-items:center;
            padding:0 30px;

        }

        .logo{

            font-size:28px;
            font-weight:bold;

        }

        .profile-circle{

            width:45px;
            height:45px;
            border-radius:50%;
            overflow:hidden;
            border:2px solid black;

        }

        .profile-circle img{

            width:100%;
            height:100%;
            object-fit:cover;

        }

        /* BANNER */

        .banner{

            width:95%;
            height:300px;
            margin:30px auto;
            border-radius:15px;
            overflow:hidden;
            position:relative;

        }

        .banner img{

            width:100%;
            height:100%;
            object-fit:cover;

        }

        .banner-overlay{

            position:absolute;
            top:0;
            left:0;
            width:100%;
            height:100%;
            background:rgba(0,0,0,0.4);

            display:flex;
            justify-content:center;
            align-items:center;

            color:white;
            font-size:60px;
            font-weight:bold;

        }

        /* SEARCH BAR */

        .search-section{

            width:95%;
            margin:auto;
            display:flex;
            gap:15px;
            margin-bottom:30px;

        }

        .search-section input{

            flex:1;
            height:50px;
            border-radius:10px;
            border:1px solid #ccc;
            padding-left:15px;

        }

        .search-section button{

            padding:0 25px;
            border:none;
            background:black;
            color:white;
            border-radius:10px;

        }

        /* SECTION TITLE */

        .section-title{

            width:95%;
            margin:30px auto 20px auto;
            font-size:28px;
            font-weight:bold;
            border-bottom:2px solid #ddd;
            padding-bottom:10px;

        }

        /* DESTINATIONS */

        .destination-grid{

            width:95%;
            margin:auto;

            display:grid;

            grid-template-columns:repeat(auto-fit,minmax(180px,1fr));

            gap:20px;

        }

        .destination-card{

            height:220px;
            border-radius:15px;
            overflow:hidden;
            position:relative;
            cursor:pointer;
            transition:0.3s;

        }

        .destination-card:hover{

            transform:scale(1.03);

        }

        .destination-card img{

            width:100%;
            height:100%;
            object-fit:cover;

        }

        .destination-name{

            position:absolute;
            bottom:0;
            left:0;
            width:100%;
            padding:15px;
            background:rgba(0,0,0,0.5);
            color:white;
            font-size:22px;
            font-weight:bold;

        }

        /* PREVIOUS TRIPS */

        .trip-grid{

            width:95%;
            margin:auto;
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
            gap:25px;
            margin-bottom:40px;

        }

        .trip-card{

            background:white;
            border-radius:15px;
            overflow:hidden;
            border:1px solid #ddd;
            transition:0.3s;

        }

        .trip-card:hover{

            transform:translateY(-5px);

        }

        .trip-card img{

            width:100%;
            height:220px;
            object-fit:cover;

        }

        .trip-content{

            padding:20px;

        }

        .trip-content h4{

            margin-bottom:10px;

        }

        .trip-content p{

            color:gray;
            margin-bottom:10px;

        }

        .plan-btn{

            position:fixed;
            bottom:30px;
            right:30px;

            background:black;
            color:white;

            padding:15px 30px;

            border-radius:15px;
            text-decoration:none;
            font-size:18px;

        }

        .empty-box{

            width:95%;
            margin:auto;
            background:#fafafa;
            border:2px dashed #ccc;
            border-radius:15px;
            padding:60px;
            text-align:center;
            margin-bottom:40px;

        }

    </style>

</head>

<body>

<div class="main-container">

    <!-- NAVBAR -->

    <div class="navbar-custom">

        <div class="logo">
            Traveloop
        </div>

        <div class="profile-circle">

            <img src="uploads/<?php echo $user['profile_photo']; ?>">

        </div>

    </div>

    <!-- BANNER -->

    <div class="banner">

        <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?q=80&w=1400&auto=format&fit=crop">

        <div class="banner-overlay">

            Explore The World

        </div>

    </div>

    <!-- SEARCH SECTION -->

    <div class="search-section">

        <input type="text" placeholder="Search destinations.....">

        <button>
            Group By
        </button>

        <button>
            Filter
        </button>

        <button>
            Sort By
        </button>

    </div>

    <!-- TOP REGIONAL SELECTIONS -->

    <div class="section-title">
        Top Regional Selections
    </div>

    <div class="destination-grid">

        <div class="destination-card">

            <img src="https://images.unsplash.com/photo-1537953773345-d172ccf13cf1?q=80&w=1200&auto=format&fit=crop">

            <div class="destination-name">
                Paris
            </div>

        </div>

        <div class="destination-card">

            <img src="https://images.unsplash.com/photo-1528164344705-47542687000d?q=80&w=1200&auto=format&fit=crop">

            <div class="destination-name">
                Tokyo
            </div>

        </div>

        <div class="destination-card">

            <img src="https://images.unsplash.com/photo-1512453979798-5ea266f8880c?q=80&w=1200&auto=format&fit=crop">

            <div class="destination-name">
                Dubai
            </div>

        </div>

        <div class="destination-card">

            <img src="https://images.unsplash.com/photo-1499856871958-5b9627545d1a?q=80&w=1200&auto=format&fit=crop">

            <div class="destination-name">
                London
            </div>

        </div>

        <div class="destination-card">

            <img src="https://images.unsplash.com/photo-1502602898657-3e91760cbb34?q=80&w=1200&auto=format&fit=crop">

            <div class="destination-name">
                Rome
            </div>

        </div>

    </div>

    <!-- PREVIOUS TRIPS -->

    <div class="section-title">
        Previous Trips
    </div>

    <?php

    if(mysqli_num_rows($tripResult) > 0)
    {
    ?>

    <div class="trip-grid">

        <?php
        while($trip = mysqli_fetch_assoc($tripResult))
        {
        ?>

        <div class="trip-card">

            <img src="https://images.unsplash.com/photo-1488646953014-85cb44e25828?q=80&w=1200&auto=format&fit=crop">

            <div class="trip-content">

                <h4>
                    <?php echo $trip['trip_name']; ?>
                </h4>

                <p>
                    <?php echo $trip['description']; ?>
                </p>

                <p>

                    <strong>Start:</strong>
                    <?php echo $trip['start_date']; ?>

                    <br>

                    <strong>End:</strong>
                    <?php echo $trip['end_date']; ?>

                </p>

                <a href="#"
                   class="btn btn-dark">

                    View Trip

                </a>

            </div>

        </div>

        <?php
        }
        ?>

    </div>

    <?php
    }
    else
    {
    ?>

    <div class="empty-box">

        <h2>
            No Trips Yet ✈️
        </h2>

        <p class="mt-3">
            Start planning your first adventure now.
        </p>

    </div>

    <?php
    }
    ?>

</div>

<!-- FLOATING BUTTON -->

<a href="create_trip.php" class="plan-btn">

    + Plan a Trip

</a>

</body>
</html>