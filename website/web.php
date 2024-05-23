<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "joselyne";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Prepare and bind statement
    $stmt = $conn->prepare("SELECT id, username, password FROM work WHERE username=?");
    $stmt->bind_param("s", $user);

    // Execute query
    $stmt->execute();

    // Get result
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($pass, $row['password'])) {
            $_SESSION['id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            header("Location: welcome.php"); // Redirect to welcome page
            exit;
        } 
        if( $_SESSION['id']=$row['id'])
{
include("home.html");
}
        else {
            // Incorrect credentials
            $error = "Invalid credentials";
        }
    } else {
        // User not found
        $error = "User not found";
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>