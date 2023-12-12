<?php
session_start();
require_once "config.php";  

$success = "";
$error = "";

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $courseTitle = isset($_POST["course_title"]) ? $_POST["course_title"] : "";
    $courseImageLink = isset($_POST["course_image_link"]) ? $_POST["course_image_link"] : "";
    $coursePrice = isset($_POST["course_price"]) ? floatval($_POST["course_price"]) : 0.00;
    $courseDescription = isset($_POST["course_description"]) ? $_POST["course_description"] : "";

    if (!empty($_FILES["course_image_upload"]["tmp_name"])) {
        $uploadDir = "uploads/";
        $courseImageFile = $uploadDir . basename($_FILES["course_image_upload"]["name"]);

        if (move_uploaded_file($_FILES["course_image_upload"]["tmp_name"], $courseImageFile)) {
            $courseImageLink = $courseImageFile;
        } else {
            $error = "Error uploading course image file.";
        }
    }

    if (!empty($courseTitle)) {
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "INSERT INTO courses (title, image_link, price, description) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssds", $courseTitle, $courseImageLink, $coursePrice, $courseDescription);

        if ($stmt->execute()) {
            $success = "Course added successfully!";
        } else {
            $error = "Error inserting course: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
}
?>




<!DOCTYPE html>
<html lang="en">

<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.17.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="interface_user.css">
    <link rel="stylesheet" type="text/css" href="admin.css">
    <link rel="icon" href="logo.png" type="image/x-icon">


</head>
<style>
     body {
            background-color: #ffffff;
        }
    </style>
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

    





<div class="arrow-container">
    <a href="#top"><i class='fas fa-arrow-circle-up'></i></a>
</div>

    <div class="container mt-5">
        <h3 class="mb-4">Add Course</h3>
        <?php if (!empty($error)) : ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
        <?php elseif (!empty($success)) : ?>
            <div class="alert alert-success" role="alert">
                <?php echo $success; ?>
            </div>
        <?php endif; ?>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
            <div class="form-group">
                <label for="course_title">Course Title:</label>
                <input type="text" class="form-control" id="course_title" name="course_title" required>
            </div>
            <div class="form-group">
                <label for="course_image_link">Course Image URL:</label>
                <input type="text" class="form-control" id="course_image_link" name="course_image_link">
            </div>
            <div class="form-group">
                <label for="course_image_upload">Upload Image from Desktop:</label>
                <input type="file" class="form-control-file" id="course_image_upload" name="course_image_upload">
            </div>
            <div class="form-group">
                <label for="course_price">Course Price:</label>
                <input type="number" class="form-control" id="course_price" name="course_price" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="course_description">Course Description:</label>
                <textarea class="form-control" id="course_description" name="course_description" rows="4" required></textarea>
            </div>

            <button type="submit" class="btn custom-enroll-btn">Add Course</button>
        </form>
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
    <script src="js/bootstrap.min.js"></script>
</body>

</html>
