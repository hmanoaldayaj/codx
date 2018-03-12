<?php
	session_start();
	include_once ("connection.php");
	// Get the data collected from the user

	//If the delete = true is sent as a parameter in the URL, then delete the record.
	if (isset($_GET['delete']) && $_GET['delete'] == "true" && $_GET['userID'] != ""){
		$query = "delete from users WHERE userid = " . $_GET['userID'];
		$result = mysqli_query($connection, $query);
		header("Location: manageUsers.php");	//Redirection information
		exit ;//Ends the script
	}

	$username = mysqli_real_escape_string($connection,$_POST['username']);
	$password= mysqli_real_escape_string($connection,trim($_POST['password']));
	$firstName = mysqli_real_escape_string($connection,trim($_POST['firstName']));
	$lastName = mysqli_real_escape_string($connection,trim($_POST['lastName']));
	$email = mysqli_real_escape_string($connection,trim($_POST['email']));
	$isAdmin = mysqli_real_escape_string($connection,trim($_POST['isAdmin']));
	$errorString = "";

	//Server side validation
	if (empty($username) or empty($password)) {
		$_SESSION["message"] = "Must enter Username and Password ";
		header("Location: signup.php");	//Redirection information
		exit ;//Ends the script
	}

	//Server side validation
	if (empty($username) or empty($password) or empty($firstName) or empty($lastName) or empty($email) ) {
		$_SESSION["message"] = "All fields on this page are required";
		header("Location: signup.php");	//Redirection information
		exit ;//Ends the script
	}

	$query = "SELECT * FROM users WHERE username = '$username' ";
	$result = mysqli_query($connection,$query) or exit("Error in query: $query. " . mysqli_error());

	//See if any rows were returned to check that the username chosen does not exist for another user.
	if ($row = mysqli_fetch_assoc($result)) {
		//Then we have a successful login
	  	//Create a session variable to store the user name.
		$_SESSION["message"] = " '$username' already exists. Please choose a different username";
		header("Location: signup.php");	//Redirection information
		exit ;//Ends the script
	}

	$query = "SELECT * FROM users WHERE email = '$email' ";
	$result = mysqli_query($connection,$query) or exit("Error in query: $query. " . mysqli_error());

	//See if any rows were returned to check that the username chosen does not exist for another user.
	if ($row = mysqli_fetch_assoc($result)) {
		//Then we have a successful login
		//Create a session variable to store the user name.
		$_SESSION["message"] = " '$email' already exists. Please choose a different email";
		header("Location: signup.php");	//Redirection information
		exit ;//Ends the script
	}

	//Encrypt the password using MD5 encryption and store it in the database. This password will not be reversible.
	$password = md5($password);
	$query = "INSERT INTO users( username,password,firstName,lastName,email,isAdmin) VALUES('$username', '$password', '$firstName', '$lastName', '$email' , '$isAdmin')";
	$result = mysqli_query($connection, $query);

	//if there was a problem - get the error message and go back
	if (mysqli_affected_rows($connection) < 0) {
		$_SESSION["message"] =  "There were errors :" . mysql_error();
	} else{
		if($userID!=""){
			$_SESSION["message"] =  "User updated successfully";
		}else{
			$_SESSION["message"] =  "User created";
		}
	}
	echo $_SESSION["message"];
	echo "isAdmin:" . $isAdmin;
	header("Location: signup.php");//Go back to the Manage Users pages
?>