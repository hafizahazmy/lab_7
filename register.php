<!-- register.php -->
<form action="register_process.php" method="post">
    Matric: <input type="text" name="matric"><br>
    Name: <input type="text" name="name"><br>
    Password: <input type="password" name="password"><br>
    Role: 
    <select name="accessLevel">
        <option value="admin">Lecture</option>
        <option value="user">Student</option>
    </select><br>
    <input type="submit" value="Submit">
</form>
