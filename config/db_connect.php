<?php 
	$conn = mysqli_connect("localhost","MTalha","test1234","rent_my_car");

	if(!$conn){
		echo "Connection Failed!!! <br>".mysqli_connect_error();
	}
 ?>