<?php
	session_start();
	if(isset($_SESSION['logged_in'])){
		unset($_SESSION['logged_in']);
	}
	
	include('config/db_connect.php');
	header('Refresh:120; url=index.php'); // cancel the booking within 2 minutes after the booking has been made otherwise booking cannot be reverting


	function booking_cancel_msg(){
		header('Refresh:5; url=index.php');
		$msg = '<div class="alert alert-danger text-center"> Booking has been Cancelled!!! </div>';
		echo $msg;
	}


	if(isset($_POST['cancel_req'])){

		//session_start();
		$bookId = $_SESSION['bookId'];

		$sql = "SELECT * FROM Booking WHERE Book_ID = $bookId ";
		$result = mysqli_query($conn,$sql);
		$book_detail = mysqli_fetch_assoc($result);
		mysqli_free_result($result);

		$billNo = $book_detail['Bill_no'];
		$cust_ssn = $book_detail['Cust_SSN'];
		$carId = $book_detail['Car_ID'];


		$sql = "UPDATE Car SET Availability = 'Available' WHERE Car_ID = $carId";

		if(mysqli_query($conn,$sql)){

			$sql = "DELETE FROM Booking WHERE Book_ID = $bookId";

			if(mysqli_query($conn,$sql)){

				$sql = "DELETE FROM Bill WHERE Bill_no = '$billNo'";

				if(mysqli_query($conn,$sql)){

					//$sql = "DELETE FROM Customer WHERE Cust_SSN = '$cust_ssn'"; not deleting the customer record as it may have previous booking in Child Table(Booking Table)
					booking_cancel_msg();

				} else{
					echo "Error in deleting the record from the Bill Table!!! <br>".mysqli_error($conn);
				}

			} else{
				echo "Error in deleting the record from the Booking Table!!! <br>".mysqli_error($conn);
			}

		} else{
			echo "Error in updating record in Car table!!! <br>".mysqli_error($conn);
		}


		mysqli_close($conn);
	}
?>

<!DOCTYPE html>
<html>
	
	<?php include('templates/header.php'); ?>

	<div class="jumbotron jumbotron-fluid text-center text-white bg-dark">
		<h1>Your Car has been Booked!!!</h1> 
		<p>You will receive the confirmation mail.</p>

		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
			<input type="submit" name="cancel_req" value="CANCEL BOOKING" class="btn btn-danger btn-outline-danger text-white">
		</form>
	</div>

	<?php include('templates/footer.php'); ?>

</html>