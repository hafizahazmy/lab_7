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

$sql = "SELECT matric, name, accessLevel FROM users";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>User List</title>
    <style>
        table {
            width: 70%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th, td a {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <h1>User List</h1>
    <?php
    if ($result->num_rows > 0) {
        echo "<table><tr><th>Matric</th><th>Name</th><th>Access Level</th><th>Actions</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["matric"]. "</td><td>" . $row["name"]. "</td><td>" . $row["accessLevel"]. "</td>";
            echo "<td><a href='update_user.php?matric=" . $row["matric"] . "'>Update</a>";
            echo "<a href='delete_user.php?matric=" . $row["matric"] . "' onclick='return confirm(\"Are you sure you want to delete this user?\");'>Delete</a></td></tr>";
        }
        echo "</table>";
    } else {
        echo "0 results";
    }
    $conn->close();
    ?>
</body>
</html>

