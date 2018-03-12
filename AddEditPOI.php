<!doctype html>
<?php
	session_start();
?>
<html lang="en">
	<head>
		<!-- One single page to Update an Existing POI or Create a new POI  -->

		<title>Edit or Create POI</title>
		<!-- Include meta elements here!  -->
		<meta charset="UTF-8"/>
		<meta name="author" content="Abdulrahman"/>
		<meta name="description" content="Web Development Project"/>

		<!-- Application custom CSS -->
		<link rel="stylesheet" href="stylesheet.css">

	</head>
	<body>
		<?php
			if (isset($_GET['poiID']))
				$poiID = $_GET["poiID"];
			else
				$poiID = "0";

			//Start with empty variables. These will be used in case of the creation of a new POI
			$title = "";
			$shortDesc = "";
			$type = "";
			$image = "";
			$price = "";
			$dateOfEvent = "";
			include_once("header.php");
			include_once("connection.php");

			//Get the information for the requested chosen event
			$query = "SELECT * FROM POI where poiID = " . $poiID;
			$result = mysqli_query($connection, $query)  or exit ("Error in query: $query. ".mysqli_error());
		?>
        <div class="row">
        	<h1>Add/Edit POI</h1>

        	<div id="errorMessage">
        		<?php echo "<h3><font color=red>".$_SESSION['message']."</font></h3>";
        		$_SESSION["message"] = ""; ?>
        	</div>
		<form method="post" action="AddEditPOIAction.php" enctype="multipart/form-data">
			<input type="hidden" name="poiID" id="poiID" value="<?php echo $poiID ?>"/>
		   <?php
		   //If we are updating an existing phone, fill in the values for that specific phone
			while ($row = mysqli_fetch_assoc($result))    {
				$poiID = $row['poiID'];
				$title = $row['title'];
				$shortDesc = $row['shortDesc'];
				$type = $row['type'];
				$image = $row['image'];
				$price = $row['price'];
				$dateOfEvent = $row['dateOfEvent'];
			 } ?>

				<div>
					<ul>
						<li>
							<div> Title </div>
							<input class="narrow text input" id="title" name="title" type="text" value="<?php echo $title; ?>"  />
						</li>
						<li>
							<div> Type </div>
							<select class="narrow text input" id="type" name="type" />
									<option value="0" <?php if($type == "0") echo "selected";?>>Sighteseeing Location</option>
									<option value="1" <?php if($type == "1") echo "selected";?>>Local Activity</option>
									<option value="2" <?php if($type == "2") echo "selected";?>>Local Event</option>
							</select>
						</li>
						<li>
							<div> Description </div>
							<input class="narrow text input" id="shortDesc" name="shortDesc" type="text" value="<?php echo $shortDesc; ?>" />
						</li>
						<li>
							<div> Price </div>
							<input class="xnarrow text input" id="price" name="price" type="text" value="<?php echo $price; ?>" />
						</li>
						<li>
							<div> Date </div>
							<input class="xnarrow text input" id="dateOfEvent" name="dateOfEvent" type="text" value="<?php echo date('d/m/Y', strtotime($dateOfEvent)); ?>" />
						</li>
						<li>
							<div> Image </div>
							<input id="image" name="image" type="file"/>
							<br/><br/><?php if($image != "") echo "<img src='images/$image'/>"; ?>
						</li>
					</ul>
					<div class="medium primary btn">
						<a><input type="Submit" value="Save"/></a>
					</div>
				</div>
			<br/><br/>
		</form>

	</body>
</html>