<?php
    include "connection.php";
    include "index_navbar.php";
    
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Library Management System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="banner">
        <div class="banner-content">
            <h1>Welcome to Our Digital Library</h1>
            <p>Discover thousands of books, manage your reading journey, and explore the world of knowledge</p>
            <?php if(!isset($_SESSION['login_student_username']) && !isset($_SESSION['login_admin_username'])): ?>
            <div class="banner-buttons mt-4">
                <a href="student.php" class="btn btn-primary">Get Started</a>
                <a href="index_books.php" class="btn btn-outline">Browse Books</a>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="trending-books all-books" style="margin-left:10px; margin-right:10px;">
        <div class="small-container">
            <h2 class="co-title">Trending Books</h2>
            <div class="row">
            <?php
                $res = mysqli_query($db, "SELECT books.bookid, books.bookpic, books.bookname, category.categoryname, authors.authorname, books.ISBN, books.quantity, books.status FROM books JOIN category ON category.categoryid = books.categoryid JOIN authors ON authors.authorid = books.authorid JOIN trendingbook ON trendingbook.bookid = books.bookid;");
                while($row = mysqli_fetch_assoc($res)) {
            ?>
                <div class="card">
                    <img src="images/<?php echo htmlspecialchars($row['bookpic']); ?>" alt="Book Image">
                    <div class="card-body">
                        <h4><?php echo htmlspecialchars($row['bookname']); ?></h4>
                        <div class="overlay"></div>
                        <div class="sub-card">
                            <p><b>Book Name:</b> <?php echo htmlspecialchars($row['bookname']); ?></p>
                            <p><b>Category Name:</b> <?php echo htmlspecialchars($row['categoryname']); ?></p>
                            <p><b>Author Name:</b> <?php echo htmlspecialchars($row['authorname']); ?></p>
                            <p><b>ISBN:</b> <?php echo htmlspecialchars($row['ISBN']); ?></p>
                            <p><b>Quantity:</b> <?php echo htmlspecialchars($row['quantity']); ?></p>
                            <p><b>Status:</b> <span><?php echo htmlspecialchars($row['status']); ?></span></p>
                        </div>
                    </div>
                </div>
            <?php } ?>
            </div>
        </div>
    </div>

    <!-- <div class="testimonial">
        <div class="small-container">
            <h2 class="co-title">Testimonial</h2>
            <div class="row">
            <?php
                $res = mysqli_query($db, "SELECT student.studentpic, student.FullName, feedback.rating, feedback.comment FROM feedback JOIN student ON student.studentid = feedback.stdid ORDER BY feedback.rating DESC");
                $count = 0;
                while($count < 3 && $row = mysqli_fetch_assoc($res)) {
            ?>
                <div class="col-3">
                    <i class="fas fa-quote-left"></i>
                    <p><?php echo htmlspecialchars($row['comment']); ?></p>
                    <div class="rating">
                        <?php
                        for ($i = 0; $i < 5; $i++) {
                            if ($i < $row['rating']) {
                                echo '<i class="fas fa-star"></i>';
                            } else {
                                echo '<i class="far fa-star"></i>';
                            }
                        }
                        ?>
                    </div>
                    <img src="images/<?php echo htmlspecialchars($row['studentpic']); ?>" alt="Student Image">
                    <h3><?php echo htmlspecialchars($row['FullName']); ?></h3>
                </div>
            <?php $count++; } ?>
            </div>
        </div>
    </div> -->

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
        function myFunction() {
            document.getElementById("myDropdown").classList.toggle("show");
        }

        window.onclick = function(event) {
            if (!event.target.matches('.dropbtn')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }
    </script>
</body>
</html>
