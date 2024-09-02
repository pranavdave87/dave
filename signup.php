<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "expense";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Signup form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "Passwords do not match!";
        exit();
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if email already exists
    $check_email_query = "SELECT * FROM expenses WHERE email='$email'";
    $result = $conn->query($check_email_query);
    if ($result->num_rows > 0) {
        echo "Email already exists!";
        exit();
    }

    // Insert user into database
    $insert_user_query = "INSERT INTO expenses(username, email, password) VALUES ('$username', '$email', '$hashed_password')";

    if ($conn->query($insert_user_query) === TRUE) {
        // Redirect to login page after successful signup
        header("Location: login.html");
        exit();
    } else {
        echo "Error: " . $insert_user_query . "<br>" . $conn->error;
    }
}

$conn->close();
?>
