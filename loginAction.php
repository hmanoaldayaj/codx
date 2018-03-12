<?php
	session_start();
	include_once ("connection.php");
	// Get the data collected from the user

	if (isset($_POST["signout"])) {
		session_destroy();
		session_start();
		$_SESSION["message"] = "You are now logged out";
		header("Location: login.php");//Go back to the login pages
	}else {
		$username = trim($_POST["username"]);
		$password = trim($_POST["password"]);

		//Check for errors
		if (empty($username) or empty($password)) {
			$_SESSION["message"] = "Must enter Username and Password";
			header("Location: login.php");	//Redirection information
			exit ;//Ends the script
		}

		$username = strip_tags($username);
		$password = strip_tags($password);

		$password = md5($password);
		$query = "SELECT * FROM users WHERE (username = '$username' or email = '$username') and password='$password'";
		$result = mysqli_query($connection,$query) or exit("Error in query: $query. " . mysqli_error());

		// see if any rows were returned
		if ($row = mysqli_fetch_assoc($result) ) {	//Then we have a successful login

			//Create a session variable to store the user name.
			$_SESSION["authenticatedUser"] = $row['firstName'];

			//We could also use information drawn from the database eg ID
			$_SESSION['userID'] = $row['userID'];//This could be used later to get more information

			$_SESSION['isAdmin'] = $row['isAdmin'];//This could be used later to get more information3

			// Relocate to the logged-in page
			header("Location: login.php");
		} else {//Login was unsuccesful
			session_destroy();
			session_start();
			$_SESSION["message"] = "Could not login as $username";
			header("Location: login.php");//Go back to the login pages
		} //End else
	}
?>