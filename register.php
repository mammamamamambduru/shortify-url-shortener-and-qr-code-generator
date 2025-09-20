<?php

include "connection/connection.php";
if (isset($_SESSION['id'])) {
    // Redirect user to the dashboard
    header("Location: dashboard.php");
    exit(); // Stop script execution
}

// Validate that data has been sent
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate data (you can add more rules)
    if (empty($username) || empty($email) || empty($password)) {
        die("Please fill in all fields.");
    }

    // Encrypt the password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Set initial dates
    $registration_date = date("Y-m-d H:i:s");
    $payment_date = null; // Initially no payment
    $expiration_date = null; // Initially no expiration
    $remaining_links = 50; // Initially no links

    // Insert data into the database
    $sql = "INSERT INTO users (username, email, contrasena_hash, registration_date, payment_date, expiration_date, remaining_links, plan)
            VALUES ('$username', '$email', '$password_hash', '$registration_date', NULL, NULL, $remaining_links, 'free')";

    if ($conn->query($sql) === TRUE) {
         header("Location: login.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <!-- Link to Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles -->
    <style>
        body {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .register-card {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
        }
        .form-control {
            border-radius: 10px;
        }
        .btn-primary {
            background-color: #6a11cb;
            border: none;
            border-radius: 10px;
        }
        .btn-primary:hover {
            background-color: #2575fc;
        }
        .text-center {
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <!-- Registration Card -->
            <div class="col-md-6">
                <div class="register-card">
                    <h2>Create an Account</h2>
                    <form action="register.php" method="POST">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password" required>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                        Show
                                    </button>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Register</button>
                    </form>
                    <div class="text-center">
                        <p>Already have an account? <a href="login.php">Log in</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Link to jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Script to toggle password visibility -->
    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordField = document.getElementById('password');
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            this.textContent = type === 'password' ? 'Show' : 'Hide';
        });
    </script>
</body>
</html>
