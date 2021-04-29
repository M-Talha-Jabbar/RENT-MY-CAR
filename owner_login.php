<?php  
	session_start();
	if(isset($_SESSION['logged_in'])){
		unset($_SESSION['logged_in']);
	}

	include('config/db_connect.php');


	$username = $pass = $warn = '';
	$error = ['username'=>'', 'pass'=>''];

	if(isset($_POST['submit'])){
		if(empty($_POST['username'])){
			$error['username'] = 'Username is required <br>';
		} else{
			$username = $_POST['username'];
		}

		if(empty($_POST['pass'])){
			$error['pass'] = 'Password is required <br>';
		} else{
			$pass = $_POST['pass'];
		}


		if(array_filter($error)){

		} else{
			$username = mysqli_real_escape_string($conn,$_POST['username']);
			$pass = mysqli_real_escape_string($conn,$_POST['pass']);


			// validating login info.
			$sql = "SELECT username, password FROM Owner";
			$result = mysqli_query($conn,$sql);
			$sys = mysqli_fetch_all($result,MYSQLI_ASSOC);
			mysqli_free_result($result);

			$flag = 0;
			foreach ($sys as $check) {
				if($check['username'] == $username && $check['password'] == $pass){
					$flag = 1;
					//echo "successfull login";

					//session_start();
					$_SESSION['logged_in'] = 1;
					$_SESSION['username'] = $check['username'];

					header('Location: panel.php');
				} 
			}

			if($flag == 0){
				$warn = 'Incorrect username or password.';
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


				<div class="col-sm-8 text-center m-auto">
					<h1 class="text-warning font-weight-bolder">Track Your Car!!!</h1>
					<p class="text-white">Log in to enter into your panel.</p>
				</div>


				<div class="col-sm-4">
					<div class="card bg-secondary">
						
						<!-- <div class="card-header"></div>-->

						<div class="card-body">
							<h4 class="font-weight bolder text-white text-center">LOG IN</h4>

							<form action="owner_login.php" method="POST">
								
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

								<div style="color: tomato;"><?php echo $warn ?></div>

								<input type="submit" name="submit" value="LOGIN" class="btn btn-warning btn-outline-warning text-white w-100 mt-3">

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