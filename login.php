<?php
session_start();

include("includes/db.php");

if(isset($_POST['login']))
{
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0)
    {
        $user = mysqli_fetch_assoc($result);

        if(password_verify($password, $user['password']))
        {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['first_name'];

            header("Location: dashboard.php");
        }
        else
        {
            echo "<script>alert('Incorrect Password');</script>";
        }
    }
    else
    {
        echo "<script>alert('Email not found');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>

    <title>Traveloop Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        body{
            background:#f2f2f2;
            font-family:Arial;
        }

        .login-container{

            width:450px;
            margin:80px auto;
            background:white;
            padding:40px;
            border-radius:15px;
            box-shadow:0 0 15px rgba(0,0,0,0.1);

        }

        .profile-circle{

            width:120px;
            height:120px;
            border-radius:50%;
            border:2px solid #ccc;
            display:flex;
            justify-content:center;
            align-items:center;
            margin:auto;
            margin-bottom:30px;
            overflow:hidden;

        }

        .profile-circle img{

            width:70px;

        }

        .form-control{

            height:50px;
            border-radius:10px;

        }

        .login-btn{

            width:180px;
            height:50px;
            border:none;
            border-radius:10px;
            background:black;
            color:white;

        }

    </style>

</head>

<body>

<div class="login-container">

    <h2 class="text-center mb-4">
        Login Screen
    </h2>

    <div class="profile-circle">

        <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png">

    </div>

    <form method="POST">

        <div class="mb-3">

            <input type="email"
                   name="email"
                   class="form-control"
                   placeholder="Username / Email"
                   required>

        </div>

        <div class="mb-4">

            <input type="password"
                   name="password"
                   class="form-control"
                   placeholder="Password"
                   required>

        </div>

        <div class="text-center">

            <button type="submit"
                    name="login"
                    class="login-btn">

                Login Button

            </button>

        </div>

        <p class="text-center mt-4">
            Don't have an account?
            <a href="signup.php">Register</a>
        </p>

    </form>

</div>

</body>
</html>