<!-- update.php -->
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $accessLevel = $_POST['accessLevel'];

    $sql = "UPDATE users SET name='$name', accessLevel='$accessLevel' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();
    header('Location: display_users.php');
    exit;
} else {
    $id = $_GET['id'];
    $sql = "SELECT * FROM users WHERE id=$id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }
}

$conn->close();
?>

<form action="update.php" method="post">
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
    Name: <input type="text" name="name" value="<?php echo $row['name']; ?>"><br>
    Access Level: 
    <select name="accessLevel">
        <option value="admin" <?php if ($row['accessLevel'] == 'admin') echo 'selected'; ?>>Admin</option>
        <option value="user" <?php if ($row['accessLevel'] == 'user') echo 'selected'; ?>>User</option>
    </select><br>
    <input type="submit" value="Update">
</form>
