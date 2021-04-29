<?php
	include('config/db_connect.php');
	

	session_start();
	$bookId = $_SESSION['bookId'];
	$amt = $_SESSION['amount'];


	$sql = "SELECT * FROM Booking bk
			INNER JOIN Customer cust ON bk.Cust_SSN = cust.Cust_SSN AND Book_ID = $bookId";

		$result = mysqli_query($conn,$sql);
		$e_detail = mysqli_fetch_assoc($result);
		mysqli_free_result($result);

		$name = $e_detail['Name'];


		// Email details
		$to_email = $e_detail['Email'];
		$subject = "Booking Confirmation Mail";
		$message = "Hi $name \nYour Booking ID is: $bookId \n\nAmount : $amt Rs.";
		$header = "From:Rent my Car\r\n";
		//$header .= "Cc:muhammadtalha11126@gmail.com \r\n";
		//$header .= "Bcc:muhammadtalha11126@gmail.com \r\n";

		if(mail($to_email,$subject,$message,$header)){
			mysqli_close($conn);
			header('Location: confirm.php');
		} else{
			echo "Email sending failed!!!";
		}
?>