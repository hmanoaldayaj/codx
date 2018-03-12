<?php
	session_start();
	include_once ("connection.php");
	// Get the data collected from the user

	//Check to see if the poiID is sent in the form. If its not, then this is a new poi creation (insert).
	//Fill in poiID = - in that case to differentiate it
	if (isset($_POST['poiID']) && $_POST['poiID']!="" && $_POST['poiID']!="0")
		$poiID = trim($_POST['poiID']);
	else
		$poiID = "-";

	if (isset($_GET['delete']) && $_GET['delete'] == "true" && $_GET['poiID'] != ""){
		$query = "delete from POI WHERE poiID = " . $_GET['poiID'];
		$result = mysqli_query($connection, $query);
		header("Location: managePOIs.php");	//Redirection information
		exit ;//Ends the script
	}

	$title = trim($_POST['title']);
	$type = trim($_POST['type']);
	$shortDesc = trim($_POST['shortDesc']);
	$price = trim($_POST['price']);
	$dateOfEvent = trim($_POST['dateOfEvent']);
	//$image = trim($_POST['image']);
	$image = basename($_FILES["image"]["name"]);
	$errorString = "";

	//check to see title and description are filled in - server side validation
	if (empty($title) or empty($shortDesc)) {
		$_SESSION["message"] = "Must enter Title and Description";
		header("Location: AddEditPOI.php");	//Redirection information
		exit ;//Ends the script
	}

	//check to see all fields are filled in - server side validation
	if (empty($price) or empty($dateOfEvent) ) {
		$_SESSION["message"] = "All fields on this page are required";
		header("Location: AddEditPOI.php");	//Redirection information
		exit ;//Ends the script
	}


	if($poiID=="-"){
		$query = "INSERT INTO POI(title,type,shortDesc,price,dateOfEvent,image) VALUES('$title', '$type', '$shortDesc', '$price', STR_TO_DATE('$dateOfEvent', '%d/%m/%Y') , '$image')";
		$result = mysqli_query($connection, $query);
		echo "result = " . $result;
	}else{
		$query = "UPDATE POI SET title = '$title', type = '$type', shortDesc ='$shortDesc', price='$price', dateOfEvent=STR_TO_DATE('$dateOfEvent', '%d/%m/%Y') , image='$image' WHERE poiID = '$poiID'";
		$result = mysqli_query($connection, $query);
	}
	echo  '</br>' . $query . '</br>';
	$target_dir = "images/";
	$target_file = $target_dir . basename($_FILES["image"]["name"]);
	$uploadOk = 1;
	echo "a";
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	// Check if image file is a actual image or fake image
	echo "b";
	$check = getimagesize($_FILES["image"]["tmp_name"]);
	echo "c";
	if($check !== false) {
		echo "File is an image - " . $check["mime"] . ".";
		if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
				echo "The file ". basename( $_FILES["image"]["name"]). " has been uploaded.";
			} else {
				echo "Sorry, there was an error uploading your file.";
			}
	} else {
		echo "File is not an image.";
		$uploadOk = 0;
	}

	//if there was a problem - get the error message and go back
	if (mysqli_affected_rows($connection) < 0) {
		$_SESSION["message"] =  "There were errors :" . mysql_error() . $query;
	} else{
		if($poiID!=""){
			$_SESSION["message"] =  "POI updated successfully";
		}else{
			$_SESSION["message"] =  "POI created";
		}
	}
	echo $_SESSION["message"];
	header("Location: managePOIs.php");//Go back to the Manage POI page
?>