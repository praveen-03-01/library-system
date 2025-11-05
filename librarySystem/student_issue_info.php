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
    <title>My Issued Books - Student Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" crossorigin="anonymous" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="request-table">
        <div class="request-container book-container">
            <div class="page-header">
                <h2 class="request-title student-info-title">
                    <i class="fas fa-book-open"></i>
                    My Issued Books
                </h2>
                <p class="page-description">Track your borrowed books, due dates, and fines</p>
            </div>
            <?php
        $e=0;
	    if(isset($_SESSION['login_student_username']))
		{

			$q1=mysqli_query($db,"SELECT studentid from student where studentid='$_SESSION[studentid]';");
		    $row=mysqli_fetch_assoc($q1);

		    $var='<p style="color:yellow; background-color:red;">EXPIRED</p>';
			$q=mysqli_query($db,"SELECT books.bookid,books.bookname,books.ISBN,books.bookpic,issueinfo.issuedate,issueinfo.returndate,
			issueinfo.approve,fine,authors.authorname,category.categoryname from  `issueinfo` join `books` on issueinfo.bookid=books.bookid join `student`on student.studentid=issueinfo.studentid join authors on authors.authorid=books.authorid join category on category.categoryid=books.categoryid where student.studentid ='$_SESSION[studentid]' and (issueinfo.approve='yes' or issueinfo.approve='$var') ORDER BY `issueinfo`.`returndate` ASC; ");
			if(mysqli_num_rows($q)==0)
			{
				?>
				<div class="no-books-message">
					<div class="no-books-content">
						<i class="fas fa-book-open"></i>
						<h3>No Books Issued</h3>
						<p>You haven't borrowed any books yet. Visit our library to discover amazing books!</p>
						<a href="student_books.php" class="btn btn-primary">
							<i class="fas fa-search"></i> Browse Books
						</a>
					</div>
				</div>
				<?php
			}
			else
			{
				$var='<p style="color:yellow; background-color:red;">EXPIRED</p>';
				$row1=mysqli_query($db,"SELECT sum(fine),student.studentid,FullName from issueinfo join student on student.studentid=issueinfo.studentid where student.studentid ='$_SESSION[studentid]' and issueinfo.approve='$var';");
                $res1=mysqli_fetch_assoc($row1);
                if(mysqli_num_rows($row1)!=0)
                {
                    ?>
                    <div class="fine-alert">
                        <div class="fine-content">
                            <i class="fas fa-exclamation-triangle"></i>
                            <div class="fine-text">
                                <h3>Outstanding Fine</h3>
                                <p class="fine-amount"><?php echo $res1['sum(fine)'] . " Tk.";?></p>
                            </div>
                        </div>
                    </div>
                    <?php
                    
                }
                
				echo "<div class='table-responsive'>";
                echo "<table class='rtable'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th><i class='fas fa-book'></i> Book Details</th>";
                echo "<th><i class='fas fa-user-edit'></i> Author</th>";
                echo "<th><i class='fas fa-tags'></i> Category</th>";
                echo "<th><i class='fas fa-barcode'></i> ISBN</th>";
                echo "<th><i class='fas fa-calendar-plus'></i> Issue Date</th>";
                echo "<th><i class='fas fa-calendar-times'></i> Return Date</th>";
                echo "<th><i class='fas fa-check-circle'></i> Status</th>";
                echo "<th><i class='fas fa-money-bill-wave'></i> Fine</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                while($row=mysqli_fetch_assoc($q))
                {
                    $d = strtotime($row['returndate']);
                    $c=strtotime(date("Y-m-d"));
                    $diff = $c - $d;
                    // if($d > $row['returndate'])
                    // {
                    //     $e=$e+1;
                    //     $var='<p style="color:yellow; background-color:red;">EXPIRED</p>';
                    //     mysqli_query($db,"UPDATE issueinfo SET approve='$var',fine=10 where `returndate`='$row[returndate]' and approve='yes' limit $e;");
                    // }
                    if($diff>0){
                        $day = floor($diff/(60*60*24));
                        $e=$e+1;
                        $var='<p style="color:yellow; background-color:red;">EXPIRED</p>';
                        $fine = $day*10;
                        mysqli_query($db,"UPDATE issueinfo SET approve='$var',fine=$fine where `returndate`='$row[returndate]' and approve='yes' limit $e;");
                    }
                    // $t=mysqli_query($db,"SELECT * FROM timer where stdid='$_SESSION[studentid]' and bid='$row[bookid]';");
                    // $res = mysqli_fetch_assoc($t);
                    // $countDownDate = strtotime($res['date']);
                    // $now = strtotime(date("Y-m-d H:i:s"));
                    // $diff = $now-$countDownDate;
                    
                    // if($diff>0){
                    //     $day = floor($diff/(1000*60*60*24));
                    //     echo $day;
                    //     $e=$e+1;
                    //     $var='<p style="color:yellow; background-color:red;">EXPIRED</p>';
                    //     $fine = $day*10;
                    //     mysqli_query($db,"UPDATE issueinfo SET approve='$var',fine=$fine where `returndate`='$row[returndate]' and approve='yes' limit $e;");
                        
                    // }
                    
                    echo "<tr>";
                    // echo "<td>"; echo $row['bookid']; echo "</td>";
                    echo "<td>
                    <div class='table-info'>
                        <img src='images/".$row['bookpic']."'>
                        <div>
                            <p>";echo $row['bookname'];echo"</p>";?>
                            
                        </div>
                    </div>
                    </td><?php
                    echo "<td>"; echo $row['authorname']; echo "</td>";
                    echo "<td>"; echo $row['categoryname']; echo "</td>";
                    echo "<td>"; echo $row['ISBN']; echo "</td>";
                    echo "<td>"; echo $row['issuedate']; echo "</td>";
                    echo "<td>"; echo $row['returndate']; echo "</td>";
                    echo "<td>"; echo $row['approve']; echo "</td>";
                    echo "<td>";
                    if($row['fine'] > 0) {
                        echo "<span class='fine-amount'>" . $row['fine'] . " Tk.</span>";
                    } else {
                        echo "<span class='no-fine'>No Fine</span>";
                    }
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
                echo "</div>";
            }
        }
            ?>
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
    <?php
    if(isset($_GET['req']))
	{
		$id=$_GET['req'];
		mysqli_query($db,"DELETE FROM issueinfo where bookid=$id AND studentid = '$_SESSION[studentid]';");
        $res=mysqli_query($db,"SELECT quantity from books where bookid=$id;");
		while($row=mysqli_fetch_assoc($res))
		{
			if($row['quantity']==0)
			{
				mysqli_query($db,"UPDATE books SET quantity=quantity+1, status='Available' where bookid=$id;");
			}
			else
			{
				mysqli_query($db,"UPDATE books SET quantity=quantity+1 where bookid=$id;");
			}
			
		}
		?>	
		<script type="text/javascript">
			alert("Request Deleted successfully.");
			
		</script>
		<script type="text/javascript">
			window.location="request_book.php";
	    </script>
		<?php
	}
	?>
</body>
</html>