<?php
include("includes/db.php");

if(isset($_POST['signup']))
{
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $additional_info = $_POST['additional_info'];

    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // PHOTO UPLOAD
    $photo_name = $_FILES['photo']['name'];
    $temp_name = $_FILES['photo']['tmp_name'];

    $folder = "uploads/" . $photo_name;

    move_uploaded_file($temp_name, $folder);

    // CHECK EMAIL
    $checkEmail = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $checkEmail);

    if(mysqli_num_rows($result) > 0)
    {
        echo "<script>alert('Email already exists');</script>";
    }
    else
    {
        $query = "INSERT INTO users
        (first_name, last_name, email, password, phone, city, country, additional_info, profile_photo)

        VALUES

        ('$first_name','$last_name','$email','$password','$phone','$city','$country','$additional_info','$photo_name')";

        if(mysqli_query($conn, $query))
        {
            echo "<script>alert('Registration Successful');</script>";
            header("Location: login.php");
        }
        else
        {
            echo mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Traveloop Register</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        body{
            background:#f2f2f2;
            font-family:Arial;
        }

        .register-container{
            width:900px;
            margin:30px auto;
            background:white;
            border-radius:15px;
            padding:40px;
            box-shadow:0 0 15px rgba(0,0,0,0.1);
        }

        .profile-photo{
            width:120px;
            height:120px;
            border-radius:50%;
            border:2px solid #ccc;
            object-fit:cover;
            display:block;
            margin:auto;
            margin-bottom:20px;
        }

        .form-control{
            height:50px;
            border-radius:10px;
        }

        textarea{
            border-radius:10px !important;
        }

        .register-btn{
            width:220px;
            height:50px;
            border:none;
            border-radius:10px;
            background:#000;
            color:white;
            font-size:18px;
        }

        .title{
            text-align:center;
            margin-bottom:20px;
            font-weight:bold;
        }

    </style>
</head>

<body>

<div class="register-container">

    <h2 class="title">Registration Screen</h2>

    <form method="POST" enctype="multipart/form-data">

        <!-- PHOTO -->

        <div class="text-center">

            <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png"
                 class="profile-photo"
                 id="preview">

            <input type="file"
                   name="photo"
                   class="form-control mt-3"
                   onchange="loadImage(event)"
                   required>

        </div>

        <br>

        <!-- ROW 1 -->

        <div class="row">

            <div class="col-md-6 mb-3">
                <input type="text"
                       name="first_name"
                       class="form-control"
                       placeholder="First Name"
                       required>
            </div>

            <div class="col-md-6 mb-3">
                <input type="text"
                       name="last_name"
                       class="form-control"
                       placeholder="Last Name"
                       required>
            </div>

        </div>

        <!-- ROW 2 -->

        <div class="row">

            <div class="col-md-6 mb-3">
                <input type="email"
                       name="email"
                       class="form-control"
                       placeholder="Email Address"
                       required>
            </div>

            <div class="col-md-6 mb-3">
                <input type="text"
                       name="phone"
                       class="form-control"
                       placeholder="Phone Number"
                       required>
            </div>

        </div>

        <!-- PASSWORD -->

        <div class="mb-3">
            <input type="password"
                   name="password"
                   class="form-control"
                   placeholder="Password"
                   required>
        </div>

        <!-- ROW 3 -->

        <div class="row">

            <div class="col-md-6 mb-3">
                <input type="text"
                       name="city"
                       class="form-control"
                       placeholder="City"
                       required>
            </div>

            <div class="col-md-6 mb-3">
                <input type="text"
                       name="country"
                       class="form-control"
                       placeholder="Country"
                       required>
            </div>

        </div>

        <!-- ADDITIONAL INFO -->

        <div class="mb-4">

            <textarea name="additional_info"
                      rows="6"
                      class="form-control"
                      placeholder="Additional Information ...."></textarea>

        </div>

        <!-- BUTTON -->

        <div class="text-center">

            <button type="submit"
                    name="signup"
                    class="register-btn">

                Register Users

            </button>

        </div>

        <p class="text-center mt-4">
            Already have an account?
            <a href="login.php">Login</a>
        </p>

    </form>

</div>

<script>

function loadImage(event)
{
    const image = document.getElementById('preview');
    image.src = URL.createObjectURL(event.target.files[0]);
}

</script>

</body>
</html>