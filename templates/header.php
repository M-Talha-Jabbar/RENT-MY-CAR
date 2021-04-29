<!--
<?php 
	/*if(!isset($_SESSION)){
    	session_start();
	}*/
?> 
-->

<head>
	<title>Rent my Car</title>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">


	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


	<!-- Font Awesome -->
	<script src="https://kit.fontawesome.com/305773b39e.js"></script>


	<style type="text/css">
		
	</style>
</head>

<body>

	<nav class="navbar navbar-expand-sm bg-dark">
		<a href="index.php" class="navbar-brand text-white"><h1 class="font-italic">Rent my Car</h1></a>

		
		<ul class="navbar-nav">

			<?php if(!isset($_SESSION['logged_in'])){ ?>
				<!-- <li class="navbar-item"><a href="#" class="btn text-white" role="button">ABOUT US</a></li> -->

				<li class="navbar-item"><a href="owner_sign_up.php" class="btn text-white" role="button">REGISTER</a></li>

				<li class="navbar-item"><a href="owner_login.php" class="btn text-white" role="button">LOG IN</a></li>

			<?php } else{ ?>
				<li class="navbar-item text-white">Hello <b><?php echo htmlspecialchars($_SESSION['username']); ?></b>      <i class="far fa-user-circle"></i></li>

				<li class="navbar-item"><a href="owner_login.php" class="btn text-white text-center" role="button">LOGOUT</a></li>

			<?php } ?>
		</ul>

	</nav>