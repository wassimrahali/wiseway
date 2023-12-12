<?php
session_start();
require_once "config.php";

if (!isset($_SESSION['username'])) {
    header("location: login.php");
    exit();
}

$email = $_SESSION['username'];
$sql = "SELECT * FROM tusers WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $name = $row['name'];
    $profilePictureName = $row['profile_picture'];
} else {
    echo "User not found";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - <?php echo $name; ?></title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/fontawesome-all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="interface_user.css">
    <link rel="icon" href="logo.png" type="image/x-icon">



</head>

    
<body>

<nav id="top" class="navbar navbar-expand-lg navbar-light custom-navbar">

    <a class="navbar-brand" href="welcome.php" style="font-family: 'fantasy', sans-serif;">
        <span> WiseWay</span>
    </a>

    <button class="navbar-toggler ml-auto custom-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"  aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
                <a class="nav-link" href="welcome.php" style=" font-family: 'Calibri Light', sans-serif; transition: color 0.3s;" onmouseover="this.style.color='#AF2F64'" onmouseout="this.style.color='#1F1E1F'">
                    Home
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link"  href="welcome.php" style="color: #1F1E1F; font-family: 'Calibri Light', sans-serif; transition: color 0.3s;" onmouseover="this.style.color='#AF2F64'" onmouseout="this.style.color='#1F1E1F'">
                    Courses
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" style="color: #1F1E1F; font-family: 'Calibri Light', sans-serif; transition: color 0.3s;" onmouseover="this.style.color='#AF2F64'" onmouseout="this.style.color='#1F1E1F'">
                    Events
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="my_courses.php" style="color: #1F1E1F; font-family: 'Calibri Light', sans-serif; transition: color 0.3s;" onmouseover="this.style.color='#AF2F64'" onmouseout="this.style.color='#1F1E1F'">
                   My Courses
                </a>
            </li>

     
            <li class="nav-item">
                <a class="nav-link" href="about.php" style="color: #1F1E1F; font-family: 'Calibri Light', sans-serif; transition: color 0.3s;" onmouseover="this.style.color='#AF2F64'" onmouseout="this.style.color='#1F1E1F'">
                    About us
                </a>

            </li>
            <li class="nav-item">
                <a class="nav-link" href="contact.php" style="color: #1F1E1F; font-family: 'Calibri Light', sans-serif; transition: color 0.3s;" onmouseover="this.style.color='#AF2F64'" onmouseout="this.style.color='#1F1E1F'">
                    Contact
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="profile_img/<?php echo $profilePictureName; ?>" alt="Profile Picture" class="rounded-circle" width="30" height="30">
                    <span><?php echo ucfirst($name); ?></span>
                </a>
                <div class="dropdown-menu" aria-labelledby="profileDropdown">
                    <a class="dropdown-item" href="update_profile.php"><i class="fas fa-cogs"></i> Settings</a>
                    <a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt"></i> Sign out</a>
                </div>
            </li>
        </ul>
    </div>
</nav>

<div class="container mt-4">
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6">
                
                <img src="profile_img/<?php echo $profilePictureName; ?>" alt="Profile Picture"
                    class="img-thumbnail" width="200">
                  
            </div>
        </div>
    </div>
        <div class="row">
            <div class="col-md-6">
            <br />
                <h2>Edit Your Profile</h2>
                <form method="post" action="update_profile.php" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="newName">New Name:</label>
                        <input type="text" class="form-control" id="newName" name="newName" value="<?php echo $name; ?>">
                    </div>

                    <div class="form-group">
                        <label for="newEmail">New Email:</label>
                        <input type="email" class="form-control" id="newEmail" name="newEmail" value="<?php echo $email; ?>">
                    </div>
                    <div class="form-group">
                        <label for="newPassword">New Password:</label>
                        <input type="password" class="form-control" id="newPassword" name="newPassword">
                    </div>
                    <div class="form-group">
                        <label for="newProfilePicture">Change Profile Picture:</label>
                        <input type="file" class="form-control-file" id="newProfilePicture" name="newProfilePicture">
                    </div>
                    <button type="submit" class="btn custom-enroll-btn">Update Profile</button>
                </form>
            </div>
        </div>
    </div>
</div>
<footer class="text-center bg-body-tertiary">
    <div class="container pt-4"></div>

    <div class="text-center p-3" style="background-color:#F4ECEF; color: black ;font-family: 'Calibri Light'">
        Copyright © 2023 WiseWay Inc. All Rights Reserved
    </div>

</footer>

<div class="loader"></div>
<script src="loader.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>
