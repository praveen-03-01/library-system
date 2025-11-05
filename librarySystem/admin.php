<?php
    // Start session at the VERY TOP
    session_start();

    include "connection.php";
    
    // Handle login before any HTML output
    if(isset($_POST['login'])) {
        $username = mysqli_real_escape_string($db, $_POST['username']);
        $password = $_POST['password'];
        
        // Query the users table for admin users
        $query = "SELECT * FROM users WHERE username='$username' AND role='admin'";
        $result = mysqli_query($db, $query);
        
        if(mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            
            // Verify the hashed password
            if(password_verify($password, $row['password_hash'])) {
                $_SESSION['login_admin_username'] = $row['username'];
                $_SESSION['admin_id'] = $row['id'];
                $_SESSION['admin_name'] = $row['name'];
                $_SESSION['admin_email'] = $row['email'];
                $_SESSION['role'] = $row['role'];
                $_SESSION['pic1'] = $row['pic'] ?? 'default_admin.jpg'; // Add default if no pic
                
                // Redirect to admin dashboard
                header("Location: admin_dashboard.php");
                exit();
            } else {
                $login_error = "Invalid password.";
            }
        } else {
            $login_error = "Admin user not found.";
        }
    }

    // Now include navbar AFTER potential redirect
    include "admin_navbar.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Library Management System</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>
<body>
    <div class="banner">
    <div class="form">
        <div class="form-container">
            <div class="form-btn">
                <span style="font-size: 1.5rem;" onclick="login()">Login</span>
            </div>
            <form action="" id="loginform" method="post">
                <input type="text" placeholder="User Name" name="username" required>
                <div style="position: relative; display: inline-block; width: 100%;">
                    <input type="password" placeholder="Password" name="password" id="adminpass" required style="width: 100%; padding-right: 40px; box-sizing: border-box;">
                    <span class="show-hide-adminpass" style="position: absolute; right: 10px; top: 40%; transform: translateY(-50%); cursor: pointer;">
                        <i class="fas fa-eye" id="eye-adminpass"></i>
                    </span>
                </div>
                <button type="submit" class="btn" name="login">Login</button>
                <a href="admin_forgot_password.php">Forgot Password?</a>
            </form>
        </div>
    </div>
</div>

    <div class="footer">
        <div class="footer-row">
            <div class="footer-left">
                <h1>Opening Hours</h1>
                <p style="justify-content: start;"><i class="far fa-clock"></i> Monday to Friday - 9am to 6pm</p>
                <!-- <p><i class="far fa-clock"></i> Saturday - 9am to 1pm</p> -->
            </div>
            
            <div class="footer-right">
                <p style="font-size: 30px; margin-right: 10px;">Get In Touch</p>
                <p>ABC Institute, Colombo, Sri Lanka <i class="fas fa-map-marker-alt"></i></p>
                <p>info@abcinstitute.lk <i class="fas fa-paper-plane"></i></p>
                <p>+94 11 2345678 <i class="fas fa-phone-alt"></i></p>
            </div>
        </div>
        <div class="social-links">
            
            <p>&copy; 2025 ABC Institute, Sri Lanka. All Rights Reserved.</p>
        </div>
    </div>
    <script>
        var pass2 = document.getElementById("adminpass");
        var showbtn2 = document.getElementById("eye-adminpass");
        showbtn2.addEventListener("click",function(){
            if(pass2.type === "password"){
                pass2.type = "text";
                showbtn2.classList.add("hide");
            }
            else{
                pass2.type = "password";
                showbtn2.classList.remove("hide");
            }
        });
    </script>
</body>
</html>