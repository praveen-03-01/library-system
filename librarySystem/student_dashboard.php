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
    <title>Student Dashboard - Library Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" crossorigin="anonymous" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="dashboard">
        <div class="dashboard-container">
            <div class="page-header">
                <h2 class="co-title">
                    <i class="fas fa-tachometer-alt"></i>
                    Student Dashboard
                </h2>
                <p class="page-description">Welcome back! Here's your library activity overview</p>
            </div>
            <div class="dashboard-row">
                <?php
             		$books=mysqli_query($db,"SELECT * FROM `books`");
             		$total_books=mysqli_num_rows($books);

             	?>
                <div class="dashboard-col-3">
                    <a href="student_books.php">
                        <div class="dashboard-icon">
                            <i class="fas fa-book"></i>
                        </div>
                        <h3><?=$total_books;?></h3>
                        <p>Total Books Available</p>
                        <div class="dashboard-arrow">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </a>
                </div>
                <?php
                    $requests=mysqli_query($db,"SELECT student.studentid,FullName,books.bookid,bookname,ISBN FROM student inner join issueinfo on student.studentid=issueinfo.studentid inner join books on issueinfo.bookid=books.bookid where issueinfo.approve='' and student.student_username='$_SESSION[login_student_username]'");
                    $total_requests=mysqli_num_rows($requests);
                ?>
                <div class="dashboard-col-3">
                    <a href="request_book.php">
                        <div class="dashboard-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h3><?=$total_requests;?></h3>
                        <p>Pending Requests</p>
                        <div class="dashboard-arrow">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </a>
                </div>
                <?php
                    $var='<p style="color:yellow; background-color:red;">EXPIRED</p>';
                    $issue=mysqli_query($db,"SELECT student.studentid,FullName,books.bookid,bookname,ISBN FROM student inner join issueinfo on student.studentid=issueinfo.studentid inner join books on issueinfo.bookid=books.bookid where student.student_username='$_SESSION[login_student_username]' and (issueinfo.approve='Yes' or issueinfo.approve='$var')");
                    $total_issue=mysqli_num_rows($issue);

                ?>
                <div class="dashboard-col-3">
                    <a href="student_issue_info.php">
                        <div class="dashboard-icon">
                            <i class="fas fa-book-reader"></i>
                        </div>
                        <h3><?=$total_issue;?></h3>
                        <p>Books Currently Issued</p>
                        <div class="dashboard-arrow">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </a>
                </div>
                
            </div>
        </div>
    </div>
    <!-- <div class="footer">
        <div class="footer-row">
            <div class="footer-left">
                <h1>Opening Hours</h1>
                <p><i class="far fa-clock"></i>Monday to Friday - 9am to 9pm</p>
                <p><i class="far fa-clock"></i>Saturday to Sunday - 8am to 11pm</p>
            </div>
            <div class="footer-right">
                <h1>Get In Touch</h1>
                <p>#30 abc Colony, xyz City IN<i class="fas fa-map-marker-alt"></i></p>
                <p>example@website.com<i class="fas fa-paper-plane"></i></p>
                <p>+8801515637957<i class="fas fa-phone-alt"></i></p>
            </div>
        </div>
        <div class="social-links">
            <i class="fab fa-facebook-f"></i>
            <i class="fab fa-twitter"></i>
            <i class="fab fa-instagram-square"></i>
            <i class="fab fa-youtube"></i>
            <p>&copy; 2021 Copyright by Nazre Imam Tahmid</p>
        </div>
    </div> -->
</body>
</html>