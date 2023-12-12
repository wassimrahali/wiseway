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
            header("location: Dashboard.php");
        } else {
            header("location: welcome.php");
        }
    } else {
        $error_message = "Invalid email or password";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.10.2/css/all.css" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="interface_user.css">
    <link rel="icon" href="logo.png" type="image/x-icon">

</head>

<body style="background-color: #F4ECEF;">


<nav id="top" class="navbar navbar-expand-lg navbar-light custom-navbar">

  <a class="navbar-brand" href="index.php" style="font-family: 'fantasy', sans-serif;">
    <span>WiseWay</span>
  </a>

  <button class="navbar-toggler ml-auto custom-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"  aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
                <a class="nav-link" href="index.php" style=" font-family: 'Calibri Light', sans-serif; transition: color 0.3s;" onmouseover="this.style.color='#AF2F64'" onmouseout="this.style.color='#1F1E1F'">
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
          <i class="fas fa-user" style="width:20px"></i><span> Account</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="profileDropdown">
            <a class="dropdown-item" data-bs-toggle="modal"
               data-bs-target="#modalLogin"><i class="fas fa-user-plus"></i> Sign In</a>
            <a class="dropdown-item"  data-bs-toggle="modal"
             data-bs-target="#modalRegistre" ><i class="fas fa-sign-in-alt"></i> Register</a>
        </div>
      </li>

    </ul>
  </div>
</nav>

<section id="about" class="about-section" style="background-color: #F4ECEF;">

    <div class="container">
        <img src="images/hero-img.png" alt="Course Image" class="fluid-image">

        <h1 style="color: #495057">Improve <span style="color:#AF2F64 ;">your skills</span><br>
            on your own to prepare <br>for a
            <span style="color:#AF2F64 ;">better future </span></h1>
        <p style="color: #495057">WiseWay, allows any student, staff or professional to acquire relevant online training to embark on the future employment opportunity with guaranteed follow-up.</p>
        <a class="btn custom-enroll-btn" data-bs-toggle="modal" data-bs-target="#modalLogin" style="margin-left: 36%; color: white;font-family: 'Segoe UI'">Sign In</a>


    </div>
</section>







<div class="arrow-container">
    <a href="#top"><i class='fas fa-arrow-circle-up'></i></a>
</div>
<footer class="text-center bg-body-tertiary">
    <div class="container pt-4"></div>

    <div class="text-center p-3" style="background-color:#F4ECEF; color: black ;font-family: 'Calibri Light'">
        Copyright © 2023 WiseWay Inc. All Rights Reserved
    </div>

</footer>

<div class="modal fade" id="modalLogin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Welcome Back to WiseWay</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img src="images/login_edited.png" alt="Welcome Image" class="img-fluid mb-3" />

                <?php if (isset($error_message)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>

                <form action="login.php" method="post">
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Username" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" />
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="rememberMe" />
                        <label class="form-check-label" for="rememberMe">Remember me</label>
                    </div>
                    <div class="modal-footer d-block">
                        <p class="float-start">Not yet account <a style="color:  #AF2F64;" data-bs-toggle="modal" data-bs-target="#modalRegistre">Sign Up</a></p>
                        <button type="submit" class="btn custom-enroll-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalRegistre" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Welcome Back to WiseWay</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
      </div>
      <div class="modal-body">
        <img src="images/login_edited.png" alt="Welcome Image" class="img-fluid mb-3" />
    
        <form action="register.php" method="post" enctype="multipart/form-data">
          <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" class="form-control" name="name" placeholder="Your Name" required />
          </div>
          <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="text" class="form-control" id="username" name="email" placeholder="Email" required />
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required />
          </div>
          <div class="mb-3">
            <label class="form-label">Profile Picture</label>
            <input type="file" class="form-control" name="profile_picture" />
          </div>
          <div class="modal-footer d-block">
            <p class="float-start">Already have an account? <a href="login.php">Log In</a></p>
            <button type="submit" class="btn custom-enroll-btn">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="loader"></div>
<script src="loader.js"></script>
<script src="js/jquery.min.js"></script>

<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js"></script>

<script src="https://www.markuptag.com/bootstrap/5/js/bootstrap.bundle.min.js"></script>
</body>

</html>