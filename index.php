<!doctype html>
<?php
	session_start();
	$_SESSION["message"] = "";
?>
<html lang="en">
	<head>

		<title>Bahrain - Points of Interests</title>

		<!-- Meta Data information  -->
		<meta charset="UTF-8"/>
		<meta name="author" content="Abdulrahman"/>
		<meta name="description" content="Web Development Project"/>

		<!-- Application custom CSS -->
		<link rel="stylesheet" href="stylesheet.css">

	</head>
	<body>
		<?php include_once("header.php"); ?>
        <div class="row">
        	<h1>Welcome to the Bahrain Points of Interests page</h1>
        	<p>This website will give you a list of all up to date points of interest in Bahrain. These include Sightseeing Locations, Local Activities and Local Events.</p>
		<br/>

		<?php include_once("footer.php"); ?>

	</body>
</html>