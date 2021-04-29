<?php
	session_start();
	if(isset($_SESSION['logged_in'])){
		unset($_SESSION['logged_in']);
	}
	
	include('config/db_connect.php');
	

	$flag = 0;

	$fullname = $username = $pass = $email = $addr = $phone = '';
	$error = ['fullname'=>'', 'username'=>'', 'pass'=>'', 'email'=>'', 'addr'=>'', 'phone'=>''];

	if(isset($_POST['submit'])){

		if(empty($_POST['fullname'])){
			$error['fullname'] = 'Name is required <br>';
		} else{
			$fullname = $_POST['fullname'];
		}

		if(empty($_POST['username'])){
			$error['username'] = 'Username is required <br>';
		} else{
			$username = $_POST['username'];

			// checking if user has enter the same existing username
			$sql = "SELECT username FROM Owner";
			$result = mysqli_query($conn,$sql);
			$same_username_check = mysqli_fetch_all($result,MYSQLI_ASSOC);

			foreach ($same_username_check as $check) {
				if($check['username'] == $username){
					$error['username'] = 'Username already exist! <br>';
				}
			}
		}

		if(empty($_POST['pass'])){
			$error['pass'] = 'Password is required <br>';
		} else{
			$pass = $_POST['pass'];
		}

		if(empty($_POST['email'])){
			$error['email'] = 'Email is required <br>';
		} else{
			$email = $_POST['email'];

			if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
				$error['email'] = "Email must be a VALID Email Address! <br>";
			}
		}

		if(empty($_POST['addr'])){
			$error['addr'] = 'Address is required <br>';
		} else{
			$addr = $_POST['addr'];
		}

		if(empty($_POST['phone'])){
			$error['phone'] = 'Contact number is required <br>';
		} else{
			$phone = $_POST['phone'];
		}


		if(array_filter($error)){

		} else{
			$fullname = mysqli_real_escape_string($conn,$_POST['fullname']);
			$username = mysqli_real_escape_string($conn,$_POST['username']);
			$pass = mysqli_real_escape_string($conn,$_POST['pass']);
			$email = mysqli_real_escape_string($conn,$_POST['email']);
			$addr = mysqli_real_escape_string($conn,$_POST['addr']);
			$phone = mysqli_real_escape_string($conn,$_POST['phone']);


			$owner_id = uniqid(); // for unique owner id

			$sql = "INSERT INTO owner VALUES ('$owner_id','$fullname','$username','$pass','$email','$addr','$phone')";

			if(mysqli_query($conn,$sql)){
				$flag = 1;
			} else {
				echo "Error in inserting record in Owner table!!! <br>".mysqli_error($conn);
			}
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
					<?php if($flag == 0){ ?>
						<h1 class="text-warning font-weight-bolder">Register Your Car Now!!!</h1>
						<p class="text-white">Sign up to register your car and Earn.</p>
					<?php } else if($flag == 1){ ?>
						<h1 class="text-warning font-weight-bolder">Successfull Sign Up!!!</h1>
						<p class="text-white">Login to enter into your panel. <a href="owner_login.php" class="font-weight-bolder text-white">LOG IN</a></p>
					<?php } ?>
				</div>


				<div class="col-sm-5">
					<div class="card bg-secondary">

						<!--<div class="card-header"></div>-->

						<div class="card-body">
							<form action="owner_sign_up.php" method="POST">

								<div class="form-group">
									<label class="text-white">FULL NAME</label>
									<input type="text" name="fullname" value="<?php echo htmlspecialchars($fullname); ?>" class="form-control" style="height:30px">

									<div style="color: tomato;"><?php echo $error['fullname'] ?></div>
								</div>

								<div class="form-group">
									<label class="text-white">USERNAME</label>
									<input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>" class="form-control" style="height:30px">

									<div style="color: tomato;"><?php echo $error['username'] ?></div>
								</div>

								<div class="form-group">
									<label class="text-white">PASSWORD</label>
									<input type="password" name="pass" value="<?php echo htmlspecialchars($pass); ?>" class="form-control" style="height:30px">

									<div style="color: tomato;"><?php echo $error['pass'] ?></div>
								</div>

								<div class="form-group">
									<label class="text-white">EMAIL</label>
									<input type="text" name="email" value="<?php echo htmlspecialchars($email); ?>" class="form-control" style="height:30px">

									<div style="color: tomato;"><?php echo $error['email'] ?></div>
								</div>


								<div class="form-group">
									<label class="text-white">ADDRESS</label>
									<input type="text" name="addr" value="<?php echo htmlspecialchars($addr); ?>" class="form-control" style="height:30px">

									<div style="color: tomato;"><?php echo $error['addr'] ?></div>
								</div>

								<div class="form-group">
									<label class="text-white">CONTACT NO</label>
									<input type="tel" name="phone" value="<?php echo htmlspecialchars($phone); ?>"class="form-control" style="height:30px">

									<div style="color: tomato;"><?php echo $error['phone'] ?></div>
								</div>

								<input type="submit" name="submit" value="SIGN UP" class="btn btn-warning btn-outline-warning text-white float-right">

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