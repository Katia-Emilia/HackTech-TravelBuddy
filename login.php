
<?php
// Start the session
session_start();

// Database connection configuration
$host = "localhost";
$user = "root";
$pass = "";
$database = "travelbud";

// Create a database connection
$conn = new mysqli($host, $user, $pass, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo '<script type="text/javascript">';
    echo 'alert("Invalid phone number or password");';
    echo '</script>';

    $phone = $_POST["phone"];
    $pw = $_POST["pw"];

    $login = "SELECT * FROM users WHERE phone_number='$phone' AND password='$pw'";
    $result = $conn->query($login);

    if ($result->num_rows > 0) {
        // Authentication successful, set session variable
        $_SESSION["user"] = $phone;

        // Redirect to index.html
        header("Location: ./index.html");
        exit(); // Ensure that no other code is executed after the redirect
    } else {
        echo '<script type="text/javascript">';
        echo 'alert("Invalid phone number or password");';
        echo '</script>';
    }
}

// Close the database connection
$conn->close();
?>

