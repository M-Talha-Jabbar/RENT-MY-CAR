<?php 
	session_start();
	if(isset($_SESSION['logged_in'])){
		unset($_SESSION['logged_in']);
	}

	include('config/db_connect.php');
	include('completed.php'); // making those cars available for booking whose previous booking was completed


	$sql = "SELECT DISTINCT Car_name FROM Car WHERE Availability = 'Available'";
	$result = mysqli_query($conn,$sql);
	$allCars = mysqli_fetch_all($result,MYSQLI_ASSOC);
	mysqli_free_result($result);


	function count_days($date1,$date2){
		$count = 0;
		for ($i=$date1; $i <= $date2; $i++){ 
			$count++;
		}
		return $count;
	}

	$ssn = $name = $addr = $email = $vehicle = $phone = $from_date = $to_date = '';
	$error = ['ssn'=>'', 'name'=>'', 'addr'=>'', 'email'=>'', 'vehicle'=>'', 'phone'=>'', 'from_date'=>'', 'to_date'=>''];


	if(isset($_POST['submit'])){

		if(empty($_POST['ssn'])){
			$error['ssn'] = 'SSN is required <br>';
		} else{
			$ssn = $_POST['ssn'];
		}

		if(empty($_POST['name'])){
			$error['name'] = 'Name is required <br>';
		} else{
			$name = $_POST['name'];
		}

		if(empty($_POST['addr'])){
			$error['addr'] = 'Address is required <br>';
		} else{
			$addr = $_POST['addr'];
		}

		if(empty($_POST['email'])){
			$error['email'] = 'Email is required <br>';
		} else{
			$email = $_POST['email'];

			if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
				$error['email'] = "Email must be a VALID Email Address! <br>";
			}
		}

		if(empty($_POST['vehicle'])){
			$error['vehicle'] = 'Select the desired Vehicle <br>';
		} else{
			$vehicle = $_POST['vehicle'];
			//echo $vehicle;
		}

		if(empty($_POST['phone'])){
			$error['phone'] = 'Contact number is required <br>';
		} else{
			$phone = $_POST['phone'];
		}

		if(empty($_POST['from_date'])){
			$error['from_date'] = 'Select date <br>';
		} else{
			$from_date = $_POST['from_date'];

			// validating date
			$date_today = date('Y-m-d');
			if($from_date < $date_today){
				$error['from_date'] = 'Select correct date <br>';
			}
		}

		if(empty($_POST['to_date'])){
			$error['to_date'] = 'Select date <br>';
		} else{
			$to_date = $_POST['to_date'];

			// validating date
			$date_today = date('Y-m-d');
			if($to_date < $date_today){
				$error['to_date'] = 'Select correct date <br>';
			}
		}


		if(array_filter($error)){

		} else{
			$ssn = mysqli_real_escape_string($conn,$_POST['ssn']);
			$name = mysqli_real_escape_string($conn,$_POST['name']);
			$addr = mysqli_real_escape_string($conn,$_POST['addr']);
			$email = mysqli_real_escape_string($conn,$_POST['email']);
			$vehicle = mysqli_real_escape_string($conn,$_POST['vehicle']);
			$phone = mysqli_real_escape_string($conn,$_POST['phone']);
			$from_date = mysqli_real_escape_string($conn,$_POST['from_date']);
			$to_date = mysqli_real_escape_string($conn,$_POST['to_date']);


			$sql = "SELECT * FROM Car WHERE Car_name = '$vehicle' AND Availability = 'Available' ";
			$result = mysqli_query($conn,$sql);
			$car = mysqli_fetch_all($result, MYSQLI_ASSOC);
			mysqli_free_result($result);


			if($car != NULL){

				$flag = 0;
				$date_today = date('Y-m-d'); 

				// conditon 1 : checking if the customer has some previous record
				$sql = "SELECT * FROM Customer WHERE Cust_SSN = '$ssn'"; 
				$result1 = mysqli_query($conn,$sql);
				$check1 = mysqli_fetch_assoc($result1);

				// condition 2 : checking if the customer has some current booking going-on
				// if customer is having a current booking going-on then it cannot make a new booking
				$sql = "SELECT * FROM Booking WHERE (Cust_SSN = '$ssn') AND ('$date_today' BETWEEN from_date AND to_date)";
				$result2 = mysqli_query($conn,$sql);
				$check2 = mysqli_fetch_assoc($result2);

				if(empty($check1)){
					
					$sql = "INSERT INTO Customer VALUES ('$ssn','$name','$addr','$email','$phone')";

				} else if(!empty($check1) && empty($check2)){
					
					$sql = "UPDATE Customer SET Addr = '$addr', Email = '$email', Phone = '$phone' 
							WHERE Cust_SSN = '$ssn'";

				} else if(!empty($check2)){

					$msg = '<div class="alert alert-danger text-center"> Currently there is a booking going-on against your SSN.!!!. <br> You can make a new booking once your previous booking will complete. </div>';
					echo $msg;

					$flag = 1;
					header('Refresh:10; url=index.php');
				}


				if($flag == 0){

					if(mysqli_query($conn,$sql)){
						$no_of_days = count_days($from_date,$to_date);
						//echo $no_of_days;
		
						$bill_no = uniqid(); //for unique bill_no
						$ttl_am = $no_of_days*$car[0]['Rate_per_day'];

						$sql = "INSERT INTO Bill VALUES ('$bill_no',$ttl_am)";

						if(mysqli_query($conn,$sql)){
							$car_id = $car[0]['Car_ID']; 

							$sql = "INSERT INTO Booking (from_date,to_date,cust_ssn,car_id,bill_no) VALUES ('$from_date',
							'$to_date','$ssn',$car_id,'$bill_no')";

							if(mysqli_query($conn,$sql)){

								$sql = "UPDATE Car SET Availability = 'Booked' WHERE Car_ID = $car_id";

								if(mysqli_query($conn,$sql)){

									$sql = "SELECT Book_ID FROM Booking WHERE Cust_SSN = '$ssn' AND Car_ID = $car_id AND 
											Bill_no = '$bill_no'";
									$result = mysqli_query($conn,$sql);
									$value = mysqli_fetch_assoc($result);
									mysqli_free_result($result);

									//session_start();
									$_SESSION['bookId'] = $value['Book_ID'];
									$_SESSION['amount'] = $ttl_am;

									header('Location: mail.php');

								} else{
									echo "Error in updating record in Car table!!! <br>".mysqli_error($conn);
								}

							} else{
								echo "Error in inserting the record in Booking table!!! <br>".mysqli_error($conn);
							}
					
						} else{
							echo "Error in inserting the record in Bill table!!! <br>".mysqli_error($conn);
						}

					} else{
						echo "Error in inserting the record in Customer table!!! <br>".mysqli_error($conn);
					}
					
				}

			} 


			else{
				echo "There is something wrong while searching the specified car.";
			}


			mysqli_close($conn);
		}
	}
?>

<!DOCTYPE html>
<html>
	
	<?php include('templates/header.php'); ?>

	<div class="jumbotron jumbotron-fluid bg-dark">
		<div class="container">
			<div class="row">


				<div class="col-sm-7 text-center m-auto">
						<h1 class="text-warning font-weight-bolder">Book Your Ideal Ride Today</h1>
						<p class="text-white">NOW! hire a car that you desire with the cheapest rates making your trip better. Best services with the best work.</p>
				</div>


				<div class="col-sm-5">
					<div class="card bg-secondary">

						<!--<div class="card-header"></div>-->

						<div class="card-body">
							<form action="index.php" method="POST">

								<div class="form-group">
									<label class="text-white">SSN</label>
									<input type="text" name="ssn" value="<?php echo htmlspecialchars($ssn); ?>" class="form-control" style="height:30px">

									<div style="color: tomato;"><?php echo $error['ssn'] ?></div>
								</div>

								<div class="form-group">
									<label class="text-white">NAME</label>
									<input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" class="form-control" style="height:30px">

									<div style="color: tomato;"><?php echo $error['name'] ?></div>
								</div>

								<div class="form-group">
									<label class="text-white">ADDRESS</label>
									<input type="text" name="addr" value="<?php echo htmlspecialchars($addr); ?>" class="form-control" style="height:30px">

									<div style="color: tomato;"><?php echo $error['addr'] ?></div>
								</div>

								<div class="form-group">
									<label class="text-white">EMAIL</label>
									<input type="text" name="email" value="<?php echo htmlspecialchars($email); ?>" class="form-control" style="height:30px">

									<div style="color: tomato;"><?php echo $error['email'] ?></div>
								</div>

								<div class="form-group">
									<label class="text-white" for="sel1">SELECT YOUR CAR</label>

									<select name="vehicle" class="form-control form-control-sm" id="sel1">

										<option value="<?php echo htmlspecialchars($vehicle); ?>">
											<?php echo htmlspecialchars($vehicle); ?></option>

										<?php foreach ($allCars as $c) { ?>
												<option><?php echo htmlspecialchars($c['Car_name']); ?></option>
										<?php } ?>

									</select>

									<div style="color: tomato;"><?php echo $error['vehicle'] ?></div>
								</div>

								<div class="form-group">
									<label class="text-white">CONTACT NO</label>
									<input type="tel" name="phone" value="<?php echo htmlspecialchars($phone); ?>" class="form-control" style="height:30px">

									<div style="color: tomato;"><?php echo $error['phone'] ?></div>
								</div>

								<div class="form-group">
									<label class="text-white">FROM DATE</label>
									<input type="date" name="from_date" value="<?php echo htmlspecialchars($from_date); ?>"class="form-control" style="height:30px">

									<div style="color: tomato;"><?php echo $error['from_date'] ?></div>
								</div>

								<div class="form-group">
									<label class="text-white">TO DATE</label>
									<input type="date" name="to_date" value="<?php echo htmlspecialchars($to_date); ?>" class="form-control" style="height:30px">

									<div style="color: tomato;"><?php echo $error['to_date'] ?></div>
								</div>

								<input type="submit" name="submit" value="BOOK NOW" class="btn btn-warning btn-outline-warning text-white float-right">

							</form>
						</div>

						<!--<div class="card-footer"></div>-->

					</div>
				</div>


			</div>
		</div>
	</div>

	<?php include('templates/footer.php'); ?>

</html>