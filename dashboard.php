<?php
session_start();
require_once "./config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM tusers WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $_SESSION['username'] = $user['email'];
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] == 'admin') {
            header("location: admin_dashboard.php");
        } else {
            header("location: welcome.php");
        }
    } else {
        $error_message = "Invalid email or password";
    }

    $stmt->close();
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
    <title>Welcome Admin</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.17.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="interface_user.css">
    <link rel="stylesheet" type="text/css" href="admin.css">
    <link rel="icon" href="logo.png" type="image/x-icon">



</head>
   


<body>
<nav id="top" class="navbar navbar-expand-lg navbar-light custom-navbar">
        <a class="navbar-brand" href="dashboard.php" style="font-family: 'fantasy', sans-serif;">
            <span> WiseWay</span>
        </a>

        <button class="navbar-toggler ml-auto custom-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="dashboard.php" style=" font-family: 'Calibri Light', sans-serif; transition: color 0.3s;" onmouseover="this.style.color='#AF2F64'" onmouseout="this.style.color='#1F1E1F'">
                        Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#courses" style="color: #1F1E1F; font-family: 'Calibri Light', sans-serif; transition: color 0.3s;" onmouseover="this.style.color='#AF2F64'" onmouseout="this.style.color='#1F1E1F'">
                    Available Courses
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" style="color: #1F1E1F; font-family: 'Calibri Light', sans-serif; transition: color 0.3s;" onmouseover="this.style.color='#AF2F64'" onmouseout="this.style.color='#1F1E1F'">
                        Events
                    </a>
                </li>
                

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Admin !
                    </a>
                    <div class="dropdown-menu" aria-labelledby="profileDropdown">
                        <a class="dropdown-item" href="update_profile.php"><i class="fas fa-cogs"></i> Settings</a>
                        <a class="dropdown-item" href="welcome.php"><i class="fas fa-chalkboard-teacher"></i> Sign in as user</a>                        
                        <a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt"></i> Sign out</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
  
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-sm-6">
                <div class="card-box bg-blue">
                    <div class="inner">
                        <h2> 1500 </h2>
                        <p> Add Courses </p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-graduation-cap" aria-hidden="true"></i>
                    </div>
                    <a href="admin_add_course.php" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card-box bg-red">
                    <div class="inner">
                        <h2> 723 </h2>
                        <p> Add Lesson </p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <a href="lesson.php" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card-box bg-green">
                    <div class="inner">
                        <h2> 0 DT </h2>
                        <p> Today’s Collection </p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-money" aria-hidden="true"></i>
                    </div>
                    <a href="#" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card-box bg-orange">
                    <div class="inner">
                        <h2> 5464 </h2>
                        <p> Manipulate Users </p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-user-plus" aria-hidden="true"></i>
                    </div>
                    <a href="admin_dashboard.php" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>

    
    <div class="container" id="courses">
    <h3 class="section-title">Available Trainings</h3>
    <div class="row">
        <?php foreach ($courses as $course) : ?>
            <div class="col-md-4">
                <div class="course-card">
                    <img src="<?php echo $course['image_link']; ?>" alt="<?php echo $course['title']; ?>">
                    <h3 style="color: #AF2F64;"><?php echo $course['title']; ?></h3>
                    <div class="card-content">
                        <p><?php echo $course['description']; ?></p>
                        <?php if ($course['price'] == 0) : ?>
                            <p class="free">Free</p>
                        <?php else : ?>
                            <p class="price"><?php echo $course['price']; ?>DT</p>
                        <?php endif; ?>
                    </div>
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
