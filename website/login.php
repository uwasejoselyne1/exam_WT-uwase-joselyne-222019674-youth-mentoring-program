<?php
session_start(); // Start the session

// Include the database connection file
include('database_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if email and password are set
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Prepare the SQL statement to prevent SQL injection
        $sql = "SELECT user_id, password FROM users WHERE email=?";
        $stmt = $connection->prepare($sql);
        
        if ($stmt === false) {
            die("Error preparing statement: " . $connection->error);
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            // Verify the hashed password
            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['user_id'];
                header("Location: home.html");
                exit();
            } else {
                header("Location: home.html");
            }
        } else {
            header("Location: home.html");
        }

        $stmt->close(); // Close the statement
    } else {
        header("Location: home.html");
    }
}

$connection->close(); // Close the database connection
?>
