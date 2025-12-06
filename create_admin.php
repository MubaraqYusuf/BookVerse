<?php
include('db_connect.php');

$name  = "Administrator";
$email = "admin@bookverse.com";
$pass  = password_hash("admin123", PASSWORD_DEFAULT);

$sql = "
INSERT INTO users (name,email,password,role)
VALUES ('$name','$email','$pass','admin')
";

if ($conn->query($sql)) {
    echo "Admin created:<br>Email: $email<br>Password: admin123<br><br>";
    echo "After logging in, delete this file (create_admin.php) for security.";
} else {
    echo "Error: " . $conn->error;
}
