<?php

    include "connection.php";
    include "student_navbar.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Library Management System</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>
<body>

<div class="banner">
    <div class="form">
        <div class="form-container">
            <div class="form-btn">
                <span onclick="login()" id="login-btn" class="form-btn-active">Login</span>
                <span onclick="reg()" id="reg-btn">Register</span>
            </div>
            <form action="" id="loginform" method="post">
                <input type="text" placeholder="User Name" name="student_username" required>
                <input type="email" placeholder="Email" name="Email" required>
                <div style="position: relative; display: inline-block; width: 100%;">
                    <input type="password" placeholder="Password" name="password" id="loginpass" required style="width: 100%; padding-right: 40px; box-sizing: border-box;">
                    <span class="show-hide-adminpass" style="position: absolute; right: 10px; top: 40%; transform: translateY(-50%); cursor: pointer;">
                        <i class="fas fa-eye" id="eye-loginpass"></i>
                    </span>
                </div>
                <button type="submit" class="btn" name="login" style="">Login</button>
                <a href="student_forgot_password.php">Forgot Password?</a>
                
            </form>

            <form action="" id="regform" method="post" enctype="multipart/form-data" style="display: none;">
                <input type="text" placeholder="User Name" name="student_username" required>
                <input type="text" placeholder="Full Name" name="FullName" required>
                <input type="email" placeholder="Email" name="Email" required>
                <div style="position: relative; display: inline-block; width: 100%;">
                    <input type="password" placeholder="Password" name="password" id="regpass" required style="width: 100%; padding-right: 40px; box-sizing: border-box;">
                    <span class="show-hide-adminpass" style="position: absolute; right: 10px; top: 40%; transform: translateY(-50%); cursor: pointer;">
                        <i class="fas fa-eye" id="eye-regpass"></i>
                    </span>
                </div>
                <input type="text" name="PhoneNumber" placeholder="Phone Number" style="" required>
                <div class="label">
                    <label for="pic">Upload Picture :</label>
                </div>
                <input type="file" name="file" class="file" value="">
                <button type="submit" class="btn" name="register">Register</button>
            </form>
        </div>
    </div>
</div>

    <?php

		if(isset($_POST['login']))
		{
			$res=mysqli_query($db,"SELECT * FROM `student` WHERE student_username='$_POST[student_username]' AND Email='$_POST[Email]' AND password='$_POST[Password]';");
			$count=mysqli_num_rows($res);
			$row=mysqli_fetch_assoc($res);
			if($count==0)
			{
				?>
				<script type="text/javascript">
					alert("The username or password doesn't match.");

				</script>
				<?php
			}
			else
			{
				$_SESSION['login_student_username'] = $_POST['student_username'];
				$_SESSION['studentid'] = $row['studentid'];
                $_SESSION['pic'] = $row['studentpic'];

				?>
				<script type="text/javascript">
					window.location="student_dashboard.php";
				</script>

				<?php

			}
		}
	?>
    <?php

    if(isset($_POST['register']) && !empty($_FILES["file"]["name"]))
    {

        $count=0;
        $sql="SELECT * from student";
        $res=mysqli_query($db,$sql);
        

        while($row=mysqli_fetch_assoc($res))
        {
            if($row['student_username']==$_POST['student_username'])
            {
                $count=$count+1;
            }
        }
        if($count==0)
        {
            move_uploaded_file($_FILES['file']['tmp_name'],"images/".$_FILES['file']['name']);
            $pic = $_FILES['file']['name'];
            mysqli_query($db,"INSERT INTO `STUDENT` VALUES('','$_POST[student_username]','$_POST[FullName]','$_POST[Email]','$_POST[Password]','$_POST[PhoneNumber]','$pic');");

            ?>
                <script type="text/javascript">
                alert("Registration successful ");
                </script>
            <?php		
        }
        else
        {
            ?>
                <script type="text/javascript">
                alert("This username is already registered.");
                </script>
            <?php
        }
    }
    else if(isset($_POST['register']))
    {

        $count=0;
        $sql="SELECT * from student";
        $res=mysqli_query($db,$sql);

        while($row=mysqli_fetch_assoc($res))
        {
            if($row['student_username']==$_POST['student_username'])
            {
                $count=$count+1;
            }
        }
        if($count==0)
        {
        mysqli_query($db,"INSERT INTO `STUDENT` VALUES('','$_POST[student_username]','$_POST[FullName]','$_POST[Email]','$_POST[Password]','$_POST[PhoneNumber]','user2.png');");

            ?>
                <script type="text/javascript">
                alert("Registration successful ");
                </script>
            <?php		
        }
        else
        {
            ?>
                <script type="text/javascript">
                alert("This username is already registered.");
                </script>
            <?php
        }
    }
    ?>


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

    <style>
    .form-btn span {
        cursor: pointer;
        display: inline-block;
        padding: 10px 20px;
        font-size: 16px;
        transition: background-color 0.3s ease;
    }
    .form-btn-active {
        background-color: #4CAF50; /* Green for active button */
        color: white;
        border-radius: 5px;
    }
    .form-btn span:not(.form-btn-active) {
        background-color: transparent;
        color: black; /* Adjust color based on your theme */
    }
</style>

    <script>
    var loginForm = document.getElementById("loginform");
    var regForm = document.getElementById("regform");
    var loginBtn = document.getElementById("login-btn");
    var regBtn = document.getElementById("reg-btn");

    function reg() {
        loginForm.style.display = "none";
        regForm.style.display = "block";
        loginBtn.classList.remove("form-btn-active");
        regBtn.classList.add("form-btn-active");
    }

    function login() {
        loginForm.style.display = "block";
        regForm.style.display = "none";
        loginBtn.classList.add("form-btn-active");
        regBtn.classList.remove("form-btn-active");
    }

    // Password toggle for login form
    var loginPass = document.getElementById("loginpass");
    var loginEye = document.getElementById("eye-loginpass");
    loginEye.addEventListener("click", function() {
        if (loginPass.type === "password") {
            loginPass.type = "text";
            loginEye.classList.remove("fa-eye");
            loginEye.classList.add("fa-eye-slash");
        } else {
            loginPass.type = "password";
            loginEye.classList.remove("fa-eye-slash");
            loginEye.classList.add("fa-eye");
        }
    });

    // Password toggle for signup form
    var regPass = document.getElementById("regpass");
    var regEye = document.getElementById("eye-regpass");
    regEye.addEventListener("click", function() {
        if (regPass.type === "password") {
            regPass.type = "text";
            regEye.classList.remove("fa-eye");
            regEye.classList.add("fa-eye-slash");
        } else {
            regPass.type = "password";
            regEye.classList.remove("fa-eye-slash");
            regEye.classList.add("fa-eye");
        }
    });
</script>
    <script>
        var pass = document.getElementById("Pass");
        var showbtn = document.getElementById("eye");
        showbtn.addEventListener("click",function(){
            if(pass.type === "password"){
                pass.type = "text";
                showbtn.classList.add("hide");
            }
            else{
                pass.type = "password";
                showbtn.classList.remove("hide");
            }
        });
    </script>
    <script>
        var pass2 = document.getElementById("Pass-reg");
        var showbtn2 = document.getElementById("eye-reg");
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