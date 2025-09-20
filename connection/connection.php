<?php
// Configuring the database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "url_shortener";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
session_start();

// Validate the transaction with PayPal
$clientID = "you api key"; // Replace with your PayPal Client ID
$secret = "you secret key"; // Replace with your PayPal Secret
?>
