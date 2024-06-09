<!-- register_process.php -->
<?php
$conn = new mysqli('localhost', 'root', '', 'Lab_7');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$matric = $_POST['matric'];
$name = $_POST['name'];
$accessLevel = $_POST['accessLevel'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$sql = "INSERT INTO users (matric, name, accessLevel, password) VALUES ('$matric', '$name', '$accessLevel', '$password')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
