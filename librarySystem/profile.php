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
	<title>Student Panel</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" crossorigin="anonymous" />
	<link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>

<body>
	<div class="profile">
		<div class="profile-container">
			<h2 class="co-title">My Profile</h2>
			<div class="profile-small-container">
				<?php
				$q = mysqli_query($db, "SELECT * FROM student WHERE studentid='$_SESSION[studentid]';");
				$row = mysqli_fetch_assoc($q);
				echo "<div class='select-img'>
				 <a href='images/" . $_SESSION['pic'] . "'><img class='profile-page-img' src='images/" . $_SESSION['pic'] . "'></a>
				 <form method='post' enctype='multipart/form-data'>
					<label id='select-profile'><i class='fas fa-camera'></i>
					<input type='file' name='file' required>
					</label>
					 <button type='submit' name='profileimg'>Update Profile Picture</button>
				 </form>  
			</div>";

				echo "<table class='profile-table table-bordered'>";
				echo "<tr><td><b>Student ID:</b></td><td>" . $row['studentid'] . "</td></tr>";
				echo "<tr><td><b>User Name:</b></td><td>" . $row['student_username'] . "</td></tr>";
				echo "<tr><td><b>Full Name:</b></td><td>" . $row['FullName'] . "</td></tr>";
				echo "<tr><td><b>Email:</b></td><td>" . $row['Email'] . "</td></tr>";
				echo "<tr><td><b>Password:</b></td><td>" . $row['Password'] . "</td></tr>";
				echo "<tr><td><b>Phone Number:</b></td><td>" . $row['PhoneNumber'] . "</td></tr>";
				echo "</table>";
				?>
				<a href="edit_profile.php?ed=<?php echo $row['studentid']; ?>">
					<button type="submit" name="submit1" class="btn btn-default"><b>Edit</b></button>
				</a>
			</div>
		</div>
	</div>

	<?php
	if (isset($_POST['profileimg'])) {
		move_uploaded_file($_FILES['file']['tmp_name'], "images/" . $_FILES['file']['name']);
		$pic = $_FILES['file']['name'];
		$_SESSION['pic'] = $pic;
		$q1 = "UPDATE student SET studentpic='$pic' WHERE studentid='" . $_SESSION['studentid'] . "';";
		if (mysqli_query($db, $q1)) {
			echo '<script>alert("Profile picture is updated successfully."); window.location = "profile.php";</script>';
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
</body>

</html>
