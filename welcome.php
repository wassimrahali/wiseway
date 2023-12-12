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


$sqlCourses = "SELECT * FROM courses";
$resultCourses = $conn->query($sqlCourses);

if ($resultCourses->num_rows > 0) {
    $courses = $resultCourses->fetch_all(MYSQLI_ASSOC);
} else {
    $courses = [];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome <?php echo $name; ?></title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.17.0/font/bootstrap-icons.css">
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
                <a class="nav-link"  href="#courses" style="color: #1F1E1F; font-family: 'Calibri Light', sans-serif; transition: color 0.3s;" onmouseover="this.style.color='#AF2F64'" onmouseout="this.style.color='#1F1E1F'">
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
                <a  class="dropdown-item" href="my_courses.php"><i class="fa-solid fa-laptop-code"></i> My Courses</a>
                    <a class="dropdown-item" href="update_profile.php"><i class="fas fa-cogs"></i> Settings</a>
                    <a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt"></i> Sign out</a>
                </div>
            </li>
        </ul>
    </div>
</nav>


<section id="about" class="about-section">

    <div class="container">
        <img src="images/cours-img.png" alt="Course Image" class="fluid-image">

        <h1>Browse our online courses</h1>
        <p>Learn the most in-demand skills for the jobs of today and tomorrow with The WiseWay A next-generation school, 100% online.</p>

    </div>
</section>




<div class="container" id="courses">
    <h3 class="section-title">Available Trainings</h3>
    <div class="row">
        <?php foreach ($courses as $course) : ?>
            <div class="col-md-4">
                <div class="course-card">
                    <img src="<?php echo $course['image_link']; ?>" alt="<?php echo $course['title']; ?>">
                    <h3 style="color: #AF2F64;"><?php echo $course['title'];  ?></h3>
                    <p><?php echo $course['description']; ?></p>
                    <p class="free">Free</p>
                    <p class="price"><?php echo $course['price']; ?>DT</p>
                    <a href="my_courses.php?enroll_course_id=<?php echo $course['id']; ?>" class="btn custom-enroll-btn">Enroll</a>

                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>


<div class="arrow-container">
    <a href="#top"><i class='fas fa-arrow-circle-up'></i></a>
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




