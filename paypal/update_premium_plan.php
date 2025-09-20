<?php
include "../connection/connection.php";

// Check if the user is authenticated
if (!isset($_SESSION['email'])) {
    die("<div class='alert alert-danger text-center'>Acceso denegado. Por favor, inicia sesión.</div>");
}

// Check if the order ID was received
if (!isset($_GET['orderID']) || empty($_GET['orderID'])) {
    die("<div class='alert alert-danger text-center'>Falta el ID de la orden.</div>");
}

$orderID = $_GET['orderID'];
$correo = $_SESSION['email'];


$apiURL = "https://api-m.sandbox.paypal.com/v2/checkout/orders/$orderID";

// Authentication with PayPal
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api-m.sandbox.paypal.com/v1/oauth2/token");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_USERPWD, "$clientID:$secret");
curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
curl_close($ch);
$tokenData = json_decode($response, true);
if (!isset($tokenData['access_token'])) {
    die("<div class='alert alert-danger text-center'>Error authenticating with PayPal.</div>");
}

$accessToken = $tokenData['access_token'];

// Validate the orderID with PayPal
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiURL);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Bearer $accessToken"
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
curl_close($ch);
$orderData = json_decode($response, true);

// Check if the transaction is valid
if (!isset($orderData['status']) || $orderData['status'] !== "COMPLETED") {
    die("<div class='alert alert-danger text-center'>La transacción no es válida o no está completada.</div>");
}

// Check if the transaction has already been processed
$stmt = $conn->prepare("SELECT id FROM transactions WHERE order_id = ?");
$stmt->bind_param("s", $orderID);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    die("<div class='alert alert-warning text-center'>This transaction has already been processed.</div>");
}
$stmt->close();

// Verify that the buyer's email matches
$payerEmail = $orderData['payer']['email_address'] ?? null;
if ($correo !== $payerEmail) {
    die("<div class='alert alert-danger text-center'>The email does not match the buyer of the transaction.</div>");
}

// Record the transaction and update the plan
$conn->begin_transaction();

try {
    // Record the transaction
    $stmt = $conn->prepare("INSERT INTO transactions (order_id, email, status) VALUES (?, ?, ?)");
    $status = "COMPLETED";
    $stmt->bind_param("sss", $orderID, $correo, $status);
    $stmt->execute();
    $stmt->close();

    // Update the user plan
    $stmt = $conn->prepare("UPDATE users SET plan = 'premium', remaining_links = 10000 WHERE email = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $stmt->close();

    $conn->commit();
    header("Location: ../dashboard.php");
    exit();
} catch (Exception $e) {
    $conn->rollback();
    die("<div class='alert alert-danger text-center'>Error al procesar la transacción: " . $e->getMessage() . "</div>");
}

$conn->close();
?>
