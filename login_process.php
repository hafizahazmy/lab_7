<!-- login_process.php -->
<?php
session_start();

$conn = new mysqli('localhost', 'root', '', 'Lab_7');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$matric = $_POST['matric'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE matric='$matric'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
        $_SESSION['loggedin'] = true;
        $_SESSION['matric'] = $row['matric'];
        header('Location: display_users.php');
        exit; // Make sure to call exit after header redirection
    } else {
        echo 'Invalid password or username, try <a href="login.php">Login</a> again';
    }
} else {
    echo 'No record';
}


$conn->close();
?>
