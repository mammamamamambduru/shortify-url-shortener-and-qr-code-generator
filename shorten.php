<?php


include "connection/connection.php";
// Start the session to track logged-in users



// Check if a URL was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['url'])) {
    $original_url = $_POST['url'];
    $user_ip = $_SERVER['REMOTE_ADDR']; // Get the user's IP

    // Check if the user is logged in
    $user_email = isset($_SESSION['email']) ? $_SESSION['email'] : null;

    if ($user_email) {
        // The user is logged in, get the number of remaining links
        $stmt = $conn->prepare("SELECT remaining_links FROM users WHERE email = ?");
        $stmt->bind_param("s", $user_email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $remaining_links = $row['remaining_links'];
        $stmt->close();

        // Check if the user has any remaining links
        if ($remaining_links <= 0) {
            header("Location: index.php?limit_reached=1");
            exit;
        }

        // Decrease the remaining links by 1
        $stmt = $conn->prepare("UPDATE users SET remaining_links = remaining_links - 1 WHERE email = ?");
        $stmt->bind_param("s", $user_email);
        $stmt->execute();
        $stmt->close();
    } else {
        // The user is not logged in, check how many links they have created by IP
        $current_month = date('Y-m');
        $stmt = $conn->prepare("SELECT COUNT(*) as link_count FROM urls WHERE user_ip = ? AND DATE_FORMAT(created_at, '%Y-%m') = ?");
        $stmt->bind_param("ss", $user_ip, $current_month);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $link_count = $row['link_count'];
        $stmt->close();

        // Check if the IP has reached the limit of 5 links
        if ($link_count >= 5) {
            header("Location: index.php?limit_reached=1");
            exit;
        }
    }

    // Generate a short ID (customize as needed)
    $short_id = substr(md5(uniqid(rand(), true)), 0, 6);

    // Insert the URL into the database
    $stmt = $conn->prepare("INSERT INTO urls (short_id, original_url, user_ip, user_email, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("ssss", $short_id, $original_url, $user_ip, $user_email);

    // Execute the query
    if ($stmt->execute()) {
        // Redirect to the main page with the shortened URL
        header("Location: index.php?shortened_url=https://examples.scattered.com/shortener/{$short_id}");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    // If no URL was submitted, redirect to the homepage
    header("Location: index.php");
}

$conn->close();
?>
