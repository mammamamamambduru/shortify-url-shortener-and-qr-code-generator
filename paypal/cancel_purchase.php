<?php
// cancel_purchase.php



// Include the connection to the database
include "../connection/connection.php";

// Check if the user is authenticated
if (!isset($_SESSION['email'])) {
    die("<div class='alert alert-danger text-center'>Acceso denegado. Por favor, inicia sesión.</div>");
}




// Get the user's email from the session
$correo = $_SESSION['email'];

// Cancellation message
$message = "Your purchase has been cancelled. If you have any questions, contact us.";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Purchase Cancelled</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-danger text-white text-center">
                <h1 class="card-title">Purchase Cancelled</h1>
            </div>
            <div class="card-body text-center">
                <p class="lead">We're sorry to see you cancel your purchase.</p>
                <p><?php echo $message; ?></p>
                <div class="mt-4">
                    <a href="../dashboard.php" class="btn btn-primary btn-lg me-2">Go to Dashboard</a>
                    <a href="../index.php" class="btn btn-secondary btn-lg">Back to Home</a>
                </div>
            </div>
            <div class="card-footer text-muted text-center">
                If you need assistance, feel free to <a href="contact.php">contact us</a>.
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
