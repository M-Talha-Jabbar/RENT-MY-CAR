<?php 
	include('config/db_connect.php');


	$date_today = date('Y-m-d');
	//echo $date_today; 

	/*$sql = "UPDATE Car c
			INNER JOIN Booking b ON c.Car_ID = b.Car_ID AND to_date < '$date_today'
			SET Availability = 'Available'";*/

	// first of all setting all cars to 'Available'
	$sql = "UPDATE Car c
			SET Availability = 'Available'"; 

	if(mysqli_query($conn,$sql)){
		
		// now setting those cars to 'Booked' whose booking has not been completed
		$sql = "UPDATE Car c
				INNER JOIN Booking b ON c.Car_ID = b.Car_ID
				SET Availability = 'Booked' WHERE to_date > '$date_today'";
		if(mysqli_query($conn,$sql)){

			// as Car_ID is a foreign key in Booking table so it can occur multiple times plus Booking table also consist of previous booking records so there was a problem in previous query that when making those car available for booking again whose booking was completed so if there are two person and both has booked the same car(same Car_ID) and one person booking was completed and other person booking is still currently going on. Since both were having same Car_ID so b/c of one booking was completed on that Car_ID we were setting that car to 'available' which was ambiguous b/c the other person has recently booked that car.

			// Now first we are updating all cars to 'available' first and then making those cars 'booked' which have current booking on them

		} else {
			echo "Error in updating records in Car table!!! query#2".mysqli_error($conn);
		}
	} else{
		echo "Error in updating records in Car table!!! query#1".mysqli_error($conn);
	}
?>