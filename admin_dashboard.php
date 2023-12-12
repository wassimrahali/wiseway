<?php
session_start();

require_once "config.php";


$action = '';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = isset($_POST['action']) ? $_POST['action'] : '';

    switch ($action) {
        case 'add':
            $email = isset($_POST['email']) ? $_POST['email'] : null;
            $password = isset($_POST['password']) ? $_POST['password'] : null;

            if (empty($email) || empty($password)) {
                echo '<div class="alert alert-danger" role="alert">Error: Email and password are required.</div>';
                exit();
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !strpos($email, 'gmail.com')) {
                echo '<div class="alert alert-danger" role="alert">Error: Invalid email address. Please enter a valid Gmail address.</div>';
                exit();
            }

            $stmt = $conn->prepare("INSERT INTO tusers (email, password, role) VALUES (?, ?, 'user')");
            if ($stmt === false) {
                echo '<div class="alert alert-danger" role="alert">Error preparing statement: ' . $conn->error . '</div>';
                exit();
            }

            $stmt->bind_param("ss", $email, $password);
            $result = $stmt->execute();

            if ($result === false) {
                echo '<div class="alert alert-danger" role="alert">Error executing statement: ' . $stmt->error . '</div>';
                exit();
            } else {
                echo '<div class="alert alert-success" role="alert">User added successfully.</div>';
            }

            $stmt->close();

            header("Location: admin_dashboard.php");
            exit();
            break;

        case 'read':
            $stmt = $conn->prepare("SELECT id, email FROM tusers WHERE role = 'user'");
            if ($stmt === false) {
                die('Error preparing statement: ' . $conn->error);
            }

            $stmt->execute();
            $result = $stmt->get_result();

            $users = array();
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }

            $stmt->close();

            echo "<h3>User List</h3>";
            echo "<table class='table'>";
            echo "<thead class='thead-dark'>";
            echo "<tr>";
            echo "<th>User ID</th>";
            echo "<th>Email</th>";
            echo "<th>Action</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            foreach ($users as $user) {
                echo "<tr>";
                echo "<td>{$user['id']}</td>";
                echo "<td>{$user['email']}</td>";
                echo "<td>";
                echo "<form action='admin_dashboard.php' method='post' style='display:inline;'>";
                echo "<input type='hidden' name='delete_id' value='{$user['id']}'>";
                echo "<input type='hidden' name='action' value='delete'>";
                echo "<button type='submit' class='btn btn-danger btn-sm'><i class='fas fa-trash-alt'></i> Delete</button>";
                echo "</form>";

                echo "<button type='button' class='btn btn-warning btn-sm' data-toggle='modal' data-target='#updateModal{$user['id']}'><i class='fas fa-edit'></i> Update</button>";

                echo "</td>";
                echo "</tr>";
            }

            echo "</tbody>";
            echo "</table>";
            break;

        case 'delete':
            $id = isset($_POST['delete_id']) ? $_POST['delete_id'] : null;

            $stmt = $conn->prepare("DELETE FROM tusers WHERE id = ?");
            if (!$stmt) {
                die('Error preparing statement: ' . $conn->error);
            } else {
                $success_message = 'User deleted successfully.';
            }

            $stmt->bind_param("i", $id);
            $result = $stmt->execute();

            if (!$result) {
                die('Error executing statement: ' . $stmt->error);
            }

            $stmt->close();

            header("Location: admin_dashboard.php");
            exit();
            break;

        case 'update':
            $update_id = isset($_POST['update_id']) ? $_POST['update_id'] : null;
            $new_email = isset($_POST['new_email']) ? $_POST['new_email'] : null;
            $new_name = isset($_POST['new_name']) ? $_POST['new_name'] : null;
            $new_password = isset($_POST['new_password']) ? $_POST['new_password'] : null;

            $stmt = $conn->prepare("UPDATE tusers SET email = ?, name = ?, password = ? WHERE id = ?");
            if (!$stmt) {
                die('Error preparing statement: ' . $conn->error);
            } else {
                $success_message = 'User updated successfully.';
            }

            $stmt->bind_param("sssi", $new_email, $new_name, $new_password, $update_id);
            $result = $stmt->execute();

            if (!$result) {
                die('Error executing statement: ' . $stmt->error);
            }

            $stmt->close();

            header("Location: admin_dashboard.php");
            exit();
            break;

        default:
            break;
    }
}

$result = $conn->query("SELECT id, email FROM tusers WHERE role = 'user'");

if (!$result) {
    die('Error fetching user data: ' . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
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

    <style>
        body {
            background-color: #ffffff;
        }

        table,
        td,
        th {
            border: 1px solid black;
        }

        table {
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #AF2F64;
            color: #fff;
        }

        td {
            background-color: #fff;
            font-size: 14px;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        @media (max-width: 576px) {

            h2,
            h3 {
                font-size: 1.5rem;
            }

            table {
                font-size: 14px;
            }
        }

        @media (max-width: 768px) {
            table {
                font-size: 15px;
            }
        }

        a {
            color: wheat;
            text-decoration: none;
        }
    </style>
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

    <div class="arrow-container">
        <a href="#top"><i class='fas fa-arrow-circle-up'></i></a>
    </div>

    <div class="container">

        <h3>Add User</h3>
        <?php if (isset($success_message)) : ?>
            <div class="alert alert-success" role="alert">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>
        <form action="admin_dashboard.php" method="post">
            <div class="form-group">
                <label>Email:</label>
                <input type="text" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <input type="hidden" name="action" value="add">
            <button type="submit" class="btn custom-enroll-btn"><i class="fas fa-plus"></i> Add User</button>
            <a href="users_list.php" class="btn btn-warning"><i class="fas fa-print"></i> Print Users</a>
        </form>
        <?php
        // Display the list of users (if available)
        if ($result->num_rows > 0) {
            echo "<br />";
            echo "<h3>User List</h3>";
            echo "<table class='table'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>User ID</th>";
            echo "<th>Email</th>";
            echo "<th>Action</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['id']}</td>";
                echo "<td>{$row['email']}</td>";
                echo "<td>";
                echo "<form action='admin_dashboard.php' method='post' style='display:inline;'>";
                echo "<input type='hidden' name='delete_id' value='{$row['id']}'>";
                echo "<input type='hidden' name='action' value='delete'>";
                echo "<button type='submit' style='margin: 5px;' class='btn custom-enroll-btn btn-sm'><i class='fas fa-trash-alt'></i> Delete</button>";
                echo "</form>";

                echo "<button type='button' class='btn btn-warning btn-sm' data-toggle='modal' data-target='#updateModal{$row['id']}'><i class='fas fa-edit'></i> Update</button>";

                echo "<div class='modal fade' id='updateModal{$row['id']}' tabindex='-1' role='dialog' aria-labelledby='updateModalLabel' aria-hidden='true'>";
                echo "<div class='modal-dialog' role='document'>";
                echo "<div class='modal-content'>";
                echo "<div class='modal-header'>";
                echo "<h5 class='modal-title' id='updateModalLabel'>Update User</h5>";
                echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
                echo "<span aria-hidden='true'>&times;</span>";
                echo "</button>";
                echo "</div>";
                echo "<div class='modal-body'>";
                echo "<form action='admin_dashboard.php' method='post'>";
                echo "<div class='form-group'>";
                echo "<label>New Email:</label>";
                echo "<input type='text' name='new_email' class='form-control' required>";
                echo "</div>";
                echo "<div class='form-group'>";
                echo "<label>New Name:</label>";
                echo "<input type='text' name='new_name' class='form-control' required>";
                echo "</div>";
                echo "<div class='form-group'>";
                echo "<label>New Password:</label>";
                echo "<input type='password' name='new_password' class='form-control' required>";
                echo "</div>";
                echo "<input type='hidden' name='update_id' value='{$row['id']}'>";
                echo "<input type='hidden' name='action' value='update'>";
                echo "<button type='submit'  class='btn btn-warning'><i class='fas fa-edit'></i> Update User</button>";
                echo "</form>";
                echo "</div>";
                echo "<div class='modal-footer'>";
                echo "<button type='button' class='btn custom-enroll-btn' data-dismiss='modal'>Close</button>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";

                echo "</td>";
                echo "</tr>";
            }

            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<p>No users found.</p>";
        }
        ?>
    </div>
    <footer class="text-center bg-body-tertiary">
        <div class="container pt-4"></div>

        <div class="text-center p-3" style="background-color:#F4ECEF; color: black ;font-family: 'Calibri Light'">
            Copyright © 2023 WiseWay Inc. All Rights Reserved
        </div>

    </footer>
    <div class="loader"></div>
<script src="loader.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>
    </div>
</body>

</html>