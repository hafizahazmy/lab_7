<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

$conn = new mysqli('localhost', 'root', '', 'Lab_7');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['matric'])) {
    $matric = $_GET['matric'];

    $sql = "SELECT matric, name, accessLevel FROM users WHERE matric = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $matric);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "No record found";
        exit;
    }

    $stmt->close();
} else {
    echo "Invalid request";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $matric = $_POST['matric'];
    $name = $_POST['name'];
    $accessLevel = $_POST['accessLevel'];

    $sql = "UPDATE users SET name = ?, accessLevel = ? WHERE matric = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $accessLevel, $matric);

    if ($stmt->execute()) {
        echo "Record updated successfully";
        header('Location: display_users.php');
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Update User</title>
</head>
<body>
    <h1>Update User</h1>
    <form method="post" action="">
        <input type="hidden" name="matric" value="<?php echo htmlspecialchars($user['matric']); ?>">
        <p>
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
        </p>
        <p>
            <label for="accessLevel">Access Level:</label>
            <input type="text" name="accessLevel" id="accessLevel" value="<?php echo htmlspecialchars($user['accessLevel']); ?>" required>
        </p>
        <p>
            <input type="submit" value="Update">
        </p>
    </form>
    <p><a href="display_users.php">Back to User List</a></p>
</body>
</html>
