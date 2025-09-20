<?php

include "connection/connection.php";

// Check if a short_id has been passed
if (isset($_GET['id'])) {
    $short_id = $_GET['id'];

    // Prepare the query to obtain the original URL
    $stmt = $conn->prepare("SELECT original_url FROM urls WHERE short_id = ?");
    $stmt->bind_param("s", $short_id);
    $stmt->execute();
    $stmt->store_result();

    // If the original URL is found, record the visit and redirect.
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($original_url);
        $stmt->fetch();

        // Capture visit information
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $visit_time = date("Y-m-d H:i:s");
        $referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        // Get country using ipinfo.io (Geolocation API)
        $country = null;
        if ($ip_address !== '127.0.0.1') { // Avoid localhost
            $geo_data = @file_get_contents("https://ipinfo.io/{$ip_address}/json");
            if ($geo_data) {
                $geo_data = json_decode($geo_data, true);
                $country = isset($geo_data['country']) ? $geo_data['country'] : null;
            }
        } else {
            $country = "Localhost"; // For local testing
        }

        // Record the visit in the visits table
        $visit_stmt = $conn->prepare("INSERT INTO visits (short_id, visit_time, ip_address, country, referrer, user_agent) VALUES (?, ?, ?, ?, ?, ?)");
        $visit_stmt->bind_param("ssssss", $short_id, $visit_time, $ip_address, $country, $referrer, $user_agent);
        $visit_stmt->execute();
        $visit_stmt->close();

        // Redirect to the original URL
        header("Location: $original_url");
        exit();
    } else {
        echo "URL not found";
    }

    $stmt->close();
} else {
    echo "A valid ID was not provided.";
}

$conn->close();
?>
