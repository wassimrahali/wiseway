<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';


$alertClass = '';
$alertMessage = '';


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $firstName = isset($_POST["first_name"]) ? htmlspecialchars($_POST["first_name"]) : "";
    $lastName = isset($_POST["last_name"]) ? htmlspecialchars($_POST["last_name"]) : "";
    $email = isset($_POST["email"]) ? htmlspecialchars($_POST["email"]) : "";
    $phoneNumber = isset($_POST["phone_number"]) ? htmlspecialchars($_POST["phone_number"]) : "";
    $proposal = isset($_POST["proposal"]) ? htmlspecialchars($_POST["proposal"]) : "";


    $mail = new PHPMailer(true);

    try {
 
        $mail->isSMTP(); 
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'wassimrahali40@gmail.com';
        $mail->Password = 'bbtckpselchxfvkt'; 
        $mail->SMTPSecure = 'tls'; 
        $mail->Port = 587;


        $mail->setFrom($email, $firstName . ' ' . $lastName);
        $mail->addAddress('wassimrahalit@gmail.com', 'Recipient Name');

     
        $mail->isHTML(true); 
        $mail->Subject = 'New Registration of Interest';
        $mail->Body = "
        
            <p><strong>Name:</strong> $firstName $lastName</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Phone Number:</strong> $phoneNumber</p>
            <p><strong>Proposal:</strong> $proposal</p>
        ";

        $mail->send();
        
       
        $alertClass = 'alert-success';
        $alertMessage = 'Message has been sent';

    } catch (Exception $e) {
       
        $alertClass = 'alert-danger';
        $alertMessage = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/fontawesome-all.min.css">
    <link rel="stylesheet" type="text/css" href="css/f-style.css">
    <link rel="stylesheet" type="text/css" href="css/s-style.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="interface_user.css">
    <link rel="icon" href="logo.png" type="image/x-icon">

</head>
<body>
<nav id="top" class="navbar navbar-expand-lg navbar-light custom-navbar">

    <a class="navbar-brand" href="welcome.php" style="font-family: 'fantasy', sans-serif;">
        <span>WiseWay</span>
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
                    <i class="fas fa-user" style="width:20px"></i><span> Account</span>
                </a>
                <div class="dropdown-menu" aria-labelledby="profileDropdown">
                    <a class="dropdown-item" href="login.php"><i class="fas fa-sign-in-alt"></i> Sign in</a>
                    <a class="dropdown-item" href="register.php"><i class="fas fa-user-plus"></i> Register</a>
                </div>
            </li>

        </ul>
    </div>
</nav>

<div class="form-body on-top-mobile">
    <div class="row">
        <div class="form-holder">
            <div class="form-content">
                <div class="form-items">
                    <h3>Register your interest</h3>
                    <p class="text-black">Do you have any questions or want to say hello?</p>
                    <?php if (!empty($alertMessage)): ?>
                        <div class="alert <?php echo $alertClass; ?>" role="alert">
                            <?php echo $alertMessage; ?>
                        </div>
                    <?php endif; ?>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="row">
                            <div class="col-12 col-sm-6">
                            <input type="text" class="form-control" placeholder="First name" name="first_name">
                            </div>
                            <div class="col-12 col-sm-6">
                                <input type="text" class="form-control" placeholder="Last name" name="last_name">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <input type="text" class="form-control" placeholder="E-mail Address" name="email">
                            </div>
                            <div class="col-12 col-sm-6">
                                <input type="text" class="form-control" placeholder="Phone Number" name="phone_number">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <textarea class="form-control" placeholder="Your message" name="proposal"></textarea>
                            </div>
                        </div>
                        <div class="row top-padding">
                            <div class="col-12 col-sm-6">
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-button text-right">
                                    <button id="submit" type="submit" class="ibtn less-padding">Submit Application</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
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
<script src="js/popper.min.js"></script>
<script src="https://www.markuptag.com/bootstrap/5/js/bootstrap.bundle.min.js"></script>
</body>
</html>