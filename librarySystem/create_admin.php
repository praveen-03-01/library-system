<?php
include "connection.php";

$username = "admin1";
$plain_password = "123"; // Change this to your desired password
$name = "System Administrator";
$email = "admin@gmail.com";

// Hash the password
$hashed_password = password_hash($plain_password, PASSWORD_BCRYPT);

// Insert into users table
$query = "INSERT INTO users (username, password_hash, name, email, role, status) 
          VALUES ('$username', '$hashed_password', '$name', '$email', 'admin', 'active')";

if(mysqli_query($db, $query)) {
    echo "Admin account created successfully!";
} else {
    echo "Error: " . mysqli_error($db);
}
?>