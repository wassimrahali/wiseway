<?php
session_start();
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $profilePictureName = "";
    if ($_FILES['profile_picture']['error'] == 0) {
        $profilePictureName = $_FILES['profile_picture']['name'];
        move_uploaded_file($_FILES['profile_picture']['tmp_name'], 'profile_pictures/' . $profilePictureName);
    }

    $sql = "INSERT INTO tusers (name, email, password, profile_picture) VALUES ('$name', '$email', '$password', '$profilePictureName')";


if ($conn->query($sql) === TRUE) {
    $_SESSION['username'] = $email;

    $registrationSuccess = true;
    header("location: index.php");
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
}
$conn->close();
?>
