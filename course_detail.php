<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "register";
session_start();
require_once "config.php";

$conn = new mysqli($servername, $username, $password, $dbname);

if (isset($_GET['course_id'])) {
    $courseId = $_GET['course_id'];

    $courseSql = "SELECT * FROM courses WHERE id = ?";
    $courseStmt = $conn->prepare($courseSql);
    $courseStmt->bind_param("i", $courseId);
    $courseStmt->execute();
    $courseResult = $courseStmt->get_result();

    if ($courseResult->num_rows > 0) {
        $course = $courseResult->fetch_assoc();
        $courseStmt->close();

        $lessonsSql = "SELECT * FROM lessons WHERE course_id = ?";
        $lessonsStmt = $conn->prepare($lessonsSql);
        $lessonsStmt->bind_param("i", $courseId);
        $lessonsStmt->execute();
        $lessonsResult = $lessonsStmt->get_result();

        $lessons = [];
        while ($row = $lessonsResult->fetch_assoc()) {
            $lessons[] = $row;
        }

        $lessonsStmt->close();
    } else {
        header("Location: error.php");
        exit();
    }
} else {
    header("Location: error.php");
    exit();
}

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
    <title>Course Details</title>
    <link rel="icon" href="logo.png" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="interface_user.css">
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

<div class="container mt-5">
    <h3 class="mb-4">Course Details</h3>

    <div class="card course-card">
        <div class="card-body">
            <h3 style="color: #AF2F64;" class="card-title"><?php echo $course['title']; ?></h3>
            <p class="card-text"><p class="free">Free</p>
            <p class="price"><?php echo $course['price']; ?>DT</p>
            <p class="card-text"><strong>Description:</strong> <?php echo $course['description']; ?></p>

            <?php if (!empty($course['image_link'])) : ?>
                <img src="<?php echo $course['image_link']; ?>" alt="Course Image" class="img-fluid rounded">
            <?php endif; ?>

            <?php if (!empty($course['video_link'])) : ?>
                <div class="embed-responsive embed-responsive-16by9 mt-3">
                    <video class="embed-responsive-item" controls>
                        <source src="<?php echo $course['video_link']; ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    <button type="button" class="btn btn-primary mt-3" data-toggle="modal" data-target="#videoModal">
                        Watch Lesson
                    </button>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="mt-5">
        <h3>Lessons for <?php echo $course['title']; ?></h3>

        <?php if (!empty($lessons)) : ?>
            <ul class="list-group">
                <?php foreach ($lessons as $lesson) : ?>
                    <li class="list-group-item lesson-item">
                        <p class="lesson-description">
                            <strong>
                                <strong>Lesson <?php echo $lesson['id']; ?>:</strong>
                            </strong> <?php echo $lesson['name']; ?><br>
                            <strong>Description:</strong> <?php echo $lesson['description']; ?><br>
                            <strong>Duration:</strong> <?php echo $lesson['duration']; ?><br>
                            <button type="button" style="margin: 10px" class="btn custom-enroll-btn" data-toggle="modal" data-target="#lessonModal<?php echo $lesson['id']; ?>">
                                Watch Lesson
                            </button>
                        </p>
                    </li>

                    <!-- Lesson Modal -->
                    <div class="modal fade" id="lessonModal<?php echo $lesson['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="lessonModalLabel<?php echo $lesson['id']; ?>" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="lessonModalLabel<?php echo $lesson['id']; ?>">Lesson <?php echo $lesson['id']; ?> : <?php echo $lesson['name']; ?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- Video Embed Code -->
                                    <div class="embed-responsive embed-responsive-16by9">
                                        <video class="embed-responsive-item" controls>
                                            <source src="<?php echo $lesson['video_path']; ?>" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn custom-enroll-btn" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </ul>
        <?php else : ?>
            <p>No lessons available for this course.</p>
        <?php endif; ?>
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
<!-- Bootstrap and jQuery Scripts -->
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>

</html>

