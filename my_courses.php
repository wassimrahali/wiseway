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



$email = $_SESSION['username'];

$alertMessage = '';
$alertClass = '';

if (isset($_GET['enroll_course_id'])) {
    $enrollCourseId = $_GET['enroll_course_id'];

    $checkEnrollmentQuery = "SELECT * FROM user_courses WHERE user_email='$email' AND course_id=$enrollCourseId";
    $resultCheckEnrollment = $conn->query($checkEnrollmentQuery);

    if ($resultCheckEnrollment->num_rows == 0) {
        $insertEnrollmentQuery = "INSERT INTO user_courses (user_email, course_id) VALUES ('$email', $enrollCourseId)";
        $resultInsertEnrollment = $conn->query($insertEnrollmentQuery);

        if (!$resultInsertEnrollment) {
            $alertMessage = "Error: " . $conn->error;
            $alertClass = "alert-danger";
        } else {
            $alertMessage = "Enrollment successful!";
            $alertClass = "alert-success";
        }
    } else {
        $alertMessage = "You are already enrolled in this course.";
        $alertClass = "alert-warning";
    }
}

if (isset($_GET['delete_course_id'])) {
    $deleteCourseId = $_GET['delete_course_id'];

    $deleteEnrollmentQuery = "DELETE FROM user_courses WHERE user_email='$email' AND course_id=$deleteCourseId";
    $resultDeleteEnrollment = $conn->query($deleteEnrollmentQuery);

    if ($resultDeleteEnrollment) {
        $alertMessage = "Course successfully removed.";
        $alertClass = "alert-success";
    } else {
        $alertMessage = "Error: " . $conn->error;
        $alertClass = "alert-danger";
    }
}

$sqlEnrolledCourses = "SELECT courses.* FROM courses INNER JOIN user_courses ON courses.id = user_courses.course_id WHERE user_courses.user_email = '$email'";

$resultEnrolledCourses = $conn->query($sqlEnrolledCourses);

if (!$resultEnrolledCourses) {
    $alertMessage = "Error: " . $conn->error;
    $alertClass = "alert-danger";
    exit();
}

if ($resultEnrolledCourses->num_rows > 0) {
    $enrolledCourses = $resultEnrolledCourses->fetch_all(MYSQLI_ASSOC);
} else {
    $enrolledCourses = [];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Enrolled Courses - <?php echo $name; ?></title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.17.0/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="interface_user.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
                    <a class="dropdown-item" href="my_courses.php"><i class="fa-solid fa-laptop-code"></i> My Courses</a>
                    <a class="dropdown-item" href="update_profile.php"><i class="fas fa-cogs"></i> Settings</a>
                    <a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt"></i> Sign out</a>
                </div>
            </li>
        </ul>
    </div>
</nav>

<?php if (empty($enrolledCourses)) : ?>
    <div class="alert alert-info" role="alert">
        You haven't enrolled in any courses yet. Explore our courses and start learning!
    </div>
<?php endif; ?>
<div class="container" id="my-courses">
    <h3 class="section-title">My Enrolled Courses</h3>

    <?php if (!empty($alertMessage)) : ?>
        <div class="alert <?php echo $alertClass; ?> alert-dismissible fade show" role="alert">
            <?php echo $alertMessage; ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <div class="row">
        <?php foreach ($enrolledCourses as $enrolledCourse) : ?>
            <div class="col-md-4">
                <div class="course-card">
                    <img src="<?php echo $enrolledCourse['image_link']; ?>" alt="<?php echo $enrolledCourse['title']; ?>">
                    <h3 style="color: #AF2F64;"><?php echo $enrolledCourse['title']; ?></h3>
                    <p><?php echo $enrolledCourse['description']; ?></p>
                    <p class="free">Free</p>
                    <p class="price"><?php echo $enrolledCourse['price']; ?>DT</p>
                    <a href="course_detail.php?course_id=<?php echo $enrolledCourse['id']; ?>" class="btn custom-enroll-btn">Details</a>
                    <button class="btn custom-enroll-btn" onclick="confirmDelete(<?php echo $enrolledCourse['id']; ?>)">
                        <i class="fa fa-trash"></i>
                    </button>

                </div>
            </div>
        <?php endforeach; ?>
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
