<?php
session_start();
// Database connection configuration
$host = "localhost";
$user = "root";
$pass = "";  // By default, WampServer has no password
$database = "travelbud";

// Create a database connection
$conn = new mysqli($host, $user, $pass, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["email"])) {
    $email = $_POST["email"];
    $pw = $_POST["pw"];
    $confirm_pw = $_POST["pw1"];

    // Check if passwords match
    if ($pw !== $confirm_pw) {
        echo '<script type="text/javascript">';
        echo 'alert("Passwords do not match");';
        echo 'window.location.href = "./index.html";';
        echo '</script>';
        exit();
    }

    // Hash the password

    // Use prepared statement to prevent SQL injection
    $signup = $conn->prepare("INSERT INTO users (phone_number, email, name, password) VALUES (?, ?, ?, ?)");
    $signup->bind_param("ssss", $phone, $email, $name, $pw);

    if ($signup->execute()) {
        // Redirect to index.html
        header("Location: ./index.html");
         // Add exit to stop further execution after redirection
    } else {
        echo $signup->execute();
        echo '<script type="text/javascript">';
        echo 'alert("$signup->execute()");';
        echo '</script>';
    }

    $signup->close(); // Close the prepared statement
}

// Close the database connection
$conn->close();
?>
