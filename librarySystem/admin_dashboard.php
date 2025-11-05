<?php

	include "connection.php";
    include "admin_navbar.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">

    <style>
        

        /* Admin Functions Section */
        .admin-functions {
            margin-top: 3rem;
            background: var(--white);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            padding: 2rem;
        }

        .functions-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            border-bottom: 2px solid var(--light-color);
            padding-bottom: 1rem;
        }

        .functions-title {
            color: var(--text-dark);
            font-size: 1.5rem;
        }

        .functions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .function-card {
            background: var(--light-color);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            transition: var(--transition);
            cursor: pointer;
            text-align: center;
        }

        .function-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-hover);
            background: var(--primary-color);
            color: var(--white);
        }

        .function-card:hover .function-icon {
            color: var(--white);
        }

        .function-icon {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: var(--primary-color);
            transition: var(--transition);
        }

        .function-name {
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .function-desc {
            font-size: 0.9rem;
            color: var(--text-light);
        }

        .function-card:hover .function-desc {
            color: rgba(255, 255, 255, 0.8);
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .dashboard-title {
            color: var(--text-dark);
            font-size: 2rem;
            margin-left: 10px;
        }

        .quick-actions {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .action-btn {
            background: var(--white);
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            padding: 0.5rem 1rem;
            border-radius: var(--border-radius);
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 500;
            margin-right: 10px;
        }

        .action-btn:hover {
            background: var(--primary-color);
            color: var(--white);
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: var(--white);
            margin: 10% auto;
            padding: 2rem;
            border-radius: var(--border-radius);
            width: 80%;
            max-width: 600px;
            box-shadow: var(--shadow-hover);
            position: relative;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            position: absolute;
            right: 1rem;
            top: 0.5rem;
            cursor: pointer;
        }

        .close:hover {
            color: var(--text-dark);
        }

        .modal-title {
            margin-bottom: 1.5rem;
            color: var(--text-dark);
            font-size: 1.5rem;
            border-bottom: 2px solid var(--light-color);
            padding-bottom: 0.5rem;
        }

        .modal-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .modal-option {
            background: var(--light-color);
            padding: 1.5rem;
            border-radius: var(--border-radius);
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
        }

        .modal-option:hover {
            background: var(--primary-color);
            color: var(--white);
            transform: translateY(-3px);
        }

        .modal-option-icon {
            font-size: 2rem;
            margin-bottom: 1rem;
        }

    </style>
</head>
<body>
    <div class="admin-dashboard">
        <div class="admin-dashboard-container">
            <div class="dashboard-header">
                <h1 class="dashboard-title">Admin Dashboard</h1>
                <div class="quick-actions">
                    <a href="logout.php">
                    <button class="action-btn"><i class="fas fa-sign-out-alt"></i> Log Out</button></a>
                </div>
            </div>
            <div class="admin-dashboard-row" style="margin-left: 10px; margin-right: 10px;">
                <?php
             		
             		$students=mysqli_query($db,"SELECT * FROM `student`");
             		$total_students=mysqli_num_rows($students);

             	?>
                <div class="dashboard-col-4">
                    <a href="student_info.php">
                        <h3><?=$total_students;?></h3>
                        Total Students
                    </a>
                </div>
                <?php
             		$books=mysqli_query($db,"SELECT * FROM `books`");
             		$total_books=mysqli_num_rows($books);

             	?>
                <div class="dashboard-col-4">
                    <a href="manage_books.php">
                        <h3><?=$total_books;?></h3>
                        Books Listed
                    </a>
                </div>
                <?php
             		$authors=mysqli_query($db,"SELECT * FROM `authors`");
             		$total_authors=mysqli_num_rows($authors);

             	?>
                 <div class="dashboard-col-4">
                    <a href="manage_authors.php">
                        <h3><?=$total_authors;?></h3>
                        Authors Listed
                    </a>
                </div>
                <?php
                    $categories=mysqli_query($db,"SELECT * FROM `category`");
                    $total_categories=mysqli_num_rows($categories);

                ?>
                <div class="dashboard-col-4">
                    <a href="manage_categories.php">
                        <h3><?=$total_categories;?></h3>
                        Categories Listed
                    </a>
                </div>
                <?php
                    $requests=mysqli_query($db,"SELECT student.studentid,FullName,books.bookid,bookname,ISBN FROM student inner join issueinfo on student.studentid=issueinfo.studentid inner join books on issueinfo.bookid=books.bookid where issueinfo.approve='' ");
                    $total_requests=mysqli_num_rows($requests);
                ?>
                <div class="dashboard-col-4">
                    <a href="request_info.php">
                        <h3><?=$total_requests;?></h3>
                        Total Books requests
                    </a>
                </div>
                <?php
                    $var='<p style="color:yellow; background-color:red;">EXPIRED</p>';
                    $issue=mysqli_query($db,"SELECT student.studentid,FullName,books.bookid,bookname,ISBN FROM student inner join issueinfo on student.studentid=issueinfo.studentid inner join books on issueinfo.bookid=books.bookid where issueinfo.approve='Yes' or issueinfo.approve='$var'");
                    $total_issue=mysqli_num_rows($issue);

                ?>
                <div class="dashboard-col-4">
                    <a href="manage_issued_books.php">
                        <h3><?=$total_issue;?></h3>
                        Total Books issued
                    </a>
                </div>
                <?php
                    $var='<p style="color:yellow; background-color:green;">RETURNED</p>';
                    $returned=mysqli_query($db,"SELECT student.studentid,FullName,books.bookid,bookname,ISBN FROM student inner join issueinfo on student.studentid=issueinfo.studentid inner join books on issueinfo.bookid=books.bookid where issueinfo.approve='$var'");
                    $total_returned=mysqli_num_rows($returned);
                ?>
                <div class="dashboard-col-4">
                    <a href="returned.php">
                        <h3><?=$total_returned;?></h3>
                        Returned Lists
                    </a>
                </div>
                <?php
                    $var='<p style="color:yellow; background-color:red;">EXPIRED</p>';
                    $expired=mysqli_query($db,"SELECT student.studentid,FullName,books.bookid,bookname,ISBN FROM student inner join issueinfo on student.studentid=issueinfo.studentid inner join books on issueinfo.bookid=books.bookid where issueinfo.approve='$var'");
                    $total_expired=mysqli_num_rows($expired);
                ?>
                <div class="dashboard-col-4">
                    <a href="expired.php">
                        <h3><?=$total_expired;?></h3>
                        Expired Lists
                    </a>
                </div>
                <?php
                    $trending=mysqli_query($db,"SELECT *FROM trendingbook;");
                    $total_trending=mysqli_num_rows($trending);
                ?>
                <div class="dashboard-col-4">
                    <a href="trending_books.php">
                        <h3><?=$total_trending;?></h3>
                        Total Trending Books
                    </a>
                </div>
            </div>
            <!-- <div class="dashboard-row">
                
            </div>
            <div class="dashboard-row">
                
            </div>     -->
     
        </div>
        <div class="admin-functions" style="margin-left: 10px; margin-right: 10px;">
                <div class="functions-header">
                    <h2 class="functions-title">Admin Functions</h2>
                    <p>Manage all library operations from one place</p>
                </div>
                
                <div class="functions-grid">
                    <div class="function-card" onclick="openModal('studentManagement')">
                        <div class="function-icon"><i class="fas fa-user-graduate"></i></div>
                        <h3 class="function-name">Student Management</h3>
                        <p class="function-desc">View, add, edit, and manage student accounts</p>
                    </div>
                    
                    <div class="function-card" onclick="openModal('bookManagement')">
                        <div class="function-icon"><i class="fas fa-book"></i></div>
                        <h3 class="function-name">Book Management</h3>
                        <p class="function-desc">Manage library books, add new books, update details</p>
                    </div>
                    
                    <div class="function-card" onclick="openModal('authorManagement')">
                        <div class="function-icon"><i class="fas fa-pen-fancy"></i></div>
                        <h3 class="function-name">Author Management</h3>
                        <p class="function-desc">Add and manage authors in the library system</p>
                    </div>
                    
                    <div class="function-card" onclick="openModal('categoryManagement')">
                        <div class="function-icon"><i class="fas fa-folder"></i></div>
                        <h3 class="function-name">Category Management</h3>
                        <p class="function-desc">Organize books into categories and genres</p>
                    </div>
                    
                    <div class="function-card" onclick="openModal('issueManagement')">
                        <div class="function-icon"><i class="fas fa-clipboard-list"></i></div>
                        <h3 class="function-name">Issue Management</h3>
                        <p class="function-desc">Manage book issuing and returns</p>
                    </div>
                    
                    <div class="function-card" onclick="openModal('feedbackManagement')">
                        <div class="function-icon"><i class="fas fa-comments"></i></div>
                        <h3 class="function-name">Feedback Management</h3>
                        <p class="function-desc">View and respond to student feedback</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Modals for Admin Functions -->
    <div id="studentManagement" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('studentManagement')">&times;</span>
            <h2 class="modal-title">Student Management</h2>
            <div class="modal-options">
                <div class="modal-option" onclick="window.location.href='student_info.php'">
                    <div class="modal-option-icon"><i class="fas fa-users"></i></div>
                    <h3>Student Info</h3>
                    <p>View and manage all students</p>
                </div>
            </div>
        </div>
    </div>

    <div id="authorManagement" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('authorManagement')">&times;</span>
            <h2 class="modal-title">Author Management</h2>
            <div class="modal-options">
                <div class="modal-option" onclick="window.location.href=''">
                    <div class="modal-option-icon"><i class="fas fa-plus-circle"></i></div>
                    <h3>Add Author</h3>
                    <p>Add a new author to the system</p>
                </div>
                <div class="modal-option" onclick="window.location.href='manage_authors.php'">
                    <div class="modal-option-icon"><i class="fas fa-cog"></i></div>
                    <h3>Manage Authors</h3>
                    <p>View and manage existing authors</p>
                </div>
            </div>
        </div>
    </div>

    <div id="categoryManagement" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('categoryManagement')">&times;</span>
            <h2 class="modal-title">Category Management</h2>
            <div class="modal-options">
                <div class="modal-option" onclick="window.location.href='add_category.php'">
                    <div class="modal-option-icon"><i class="fas fa-plus-circle"></i></div>
                    <h3>Add Category</h3>
                    <p>Add a new book category</p>
                </div>
                <div class="modal-option" onclick="window.location.href='manage_categories.php'">
                    <div class="modal-option-icon"><i class="fas fa-cog"></i></div>
                    <h3>Manage Categories</h3>
                    <p>View and manage existing categories</p>
                </div>
            </div>
        </div>
    </div>

    <div id="bookManagement" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('bookManagement')">&times;</span>
            <h2 class="modal-title">Book Management</h2>
            <div class="modal-options">
                <div class="modal-option" onclick="window.location.href='add_book.php'">
                    <div class="modal-option-icon"><i class="fas fa-plus-circle"></i></div>
                    <h3>Add Book</h3>
                    <p>Add a new book to the library</p>
                </div>
                <div class="modal-option" onclick="window.location.href='manage_books.php'">
                    <div class="modal-option-icon"><i class="fas fa-cog"></i></div>
                    <h3>Manage Books</h3>
                    <p>View and manage existing books</p>
                </div>
                <div class="modal-option" onclick="window.location.href='trending_books.php'">
                    <div class="modal-option-icon"><i class="fas fa-fire"></i></div>
                    <h3>Trending Books</h3>
                    <p>View and manage trending books</p>
                </div>
                <div class="modal-option" onclick="window.location.href='request_info.php'">
                    <div class="modal-option-icon"><i class="fas fa-question-circle"></i></div>
                    <h3>Request Info</h3>
                    <p>View book requests from students</p>
                </div>
            </div>
        </div>
    </div>

    <div id="issueManagement" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('issueManagement')">&times;</span>
            <h2 class="modal-title">Issue Management</h2>
            <div class="modal-options">
                <div class="modal-option" onclick="window.location.href='manage_issued_books.php'">
                    <div class="modal-option-icon"><i class="fas fa-clipboard-list"></i></div>
                    <h3>Manage Issued Books</h3>
                    <p>View and manage all issued books</p>
                </div>
                <div class="modal-option" onclick="window.location.href='returned.php'">
                    <div class="modal-option-icon"><i class="fas fa-undo"></i></div>
                    <h3>Returned Lists</h3>
                    <p>View returned books history</p>
                </div>
                <div class="modal-option" onclick="window.location.href='expired.php'">
                    <div class="modal-option-icon"><i class="fas fa-exclamation-triangle"></i></div>
                    <h3>Expired Lists</h3>
                    <p>View expired book issues</p>
                </div>
            </div>
        </div>
    </div>

    <div id="feedbackManagement" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('feedbackManagement')">&times;</span>
            <h2 class="modal-title">Feedback Management</h2>
            <div class="modal-options">
                <div class="modal-option" onclick="window.location.href='feedback_info.php'">
                    <div class="modal-option-icon"><i class="fas fa-comments"></i></div>
                    <h3>Feedback List</h3>
                    <p>View and respond to student feedback</p>
                </div>
            </div>
        </div>
    </div>

    <div id="messageManagement" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('messageManagement')">&times;</span>
            <h2 class="modal-title">Message Center</h2>
            <div class="modal-options">
                <div class="modal-option" onclick="window.location.href='admin_message.php'">
                    <div class="modal-option-icon"><i class="fas fa-envelope"></i></div>
                    <h3>Messages</h3>
                    <p>View and manage messages</p>
                </div>
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
        function openModal(modalId) {
            document.getElementById(modalId).style.display = "block";
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = "none";
        }

        window.onclick = function(event) {
            var modals = document.getElementsByClassName('modal');
            for (var i = 0; i < modals.length; i++) {
                if (event.target == modals[i]) {
                    modals[i].style.display = "none";
                }
            }
        }
    </script>
</body>
</html>