<?php
	session_start();
	$_SESSION["message"] = "";
?>
<html lang="en">
	<head>

		<title>Manage POIs</title>
		<!-- This page shows all the POIs with the possibility of ordering by price or by short description  -->

		<!-- Include meta elements here!  -->
		<meta charset="UTF-8"/>
		<meta name="author" content="Abdulrahman"/>
		<meta name="description" content="Web Development Project"/>

		<!-- Application custom CSS -->
		<link rel="stylesheet" href="stylesheet.css">

	</head>
	<body>
		<?php include_once("header.php"); ?>

		<div>

		<?php if (isset($_SESSION["isAdmin"]) && $_SESSION["isAdmin"] == 1) { ?>
			<div>
				<a href="AddEditPOI.php">Add New POI</a><br/>
			</div>
		<?php } else { ?>
			<form method="post" action="managePOIs.php">
				Search: <input type="text" id="searchDesc" name="searchDesc">
				POI Type:	<select class="narrow text input" id="POItype" name="POItype" />
								<option value="">Select to Filter by Type</option>
								<option value="0">Sighteseeing Location</option>
								<option value="1">Local Activity</option>
								<option value="2">Local Event</option>
							</select>
				<input type="submit" value="Search">
			</form>
		<?php } ?>
		<br/>

		<table>
				<tr>
					<th>Type</th>
					<th>Title</th>
					<th>Short Description&nbsp;&nbsp;<a href="managePOIs.php?o=descAsc"><img src="images/up-icon.png"/></a><a href="managePOIs.php?o=descDesc"><img src="images/down-icon.png"/></a></th>
					<th>Price&nbsp;&nbsp;&nbsp;<a href="managePOIs.php?o=priceAsc"><img src="images/up-icon.png"/></a><a href="managePOIs.php?o=priceDesc"><img src="images/down-icon.png"/></a></th>
					<th>Date&nbsp;&nbsp;&nbsp;<a href="managePOIs.php?o=dateAsc"><img src="images/up-icon.png"/></a><a href="managePOIs.php?o=dateDesc"><img src="images/down-icon.png"/></a></th>
					<th>Image</th>
					<?php if (isset($_SESSION["isAdmin"]) && $_SESSION["isAdmin"] == 1) { ?> <th>Delete</th> <?php } ?>
				</tr>

				<?php
					$_SESSION["message"] = "";
					include_once("connection.php");
					$query = "SELECT * FROM POI p, poi_types t where p.type = t.type_id";


					if (isset($_POST["searchDesc"])){
						$search = $_POST['searchDesc'];
						if($search != "") { $query = $query . " and shortDesc like '%$search%'"; }
					}

					if (isset($_POST["POItype"])){
						$POItype = $_POST['POItype'];
						if($POItype != "") { $query = $query . " and p.type = $POItype"; }
					}

					//Adding the order to the query depending on the value of the o parameter sent in the URL.
					if (isset($_GET["o"])) {
						$orderby = $_GET["o"];
						switch ($orderby) {
							case "descAsc": $query = $query . " ORDER BY shortDesc ASC "; break;
							case "descDesc": $query = $query . " ORDER BY shortDesc DESC "; break;
							case "priceAsc": $query = $query . " ORDER BY price ASC "; break;
							case "priceDesc": $query = $query . " ORDER BY price DESC "; break;
							case "dateAsc": $query = $query . " ORDER BY dateOfEvent ASC "; break;
							case "dateDesc": $query = $query . " ORDER BY dateOfEvent DESC "; break;
						}
					}

					$result = mysqli_query($connection, $query)  or exit ("Error in query: $query. ".mysqli_error());
					while ($row = mysqli_fetch_assoc($result))    {
				?>
					<tr>
						<!-- Using a hyperlink to go from the list to the Editing page  -->
						<td style='width:100px'> <?php echo "<a href='AddEditPOI.php?poiID=" . $row['poiID'] . "'> " . $row['type_label'] . " </a>"; ?>  </td>
						<td style='width:100px'> <?php echo $row['title']; ?> </td>
						<td style='width:500px'> <?php echo $row['shortDesc']; ?> </td>
						<td style='width:100px'> <?php echo $row['price']; ?> </td>
						<td style='width:100px;text-align:center'> <?php echo date('d/m/Y', strtotime($row['dateOfEvent'])); ?> </td>
						<td style='width:100px;text-align:center'>
							<?php
								if($row['image']!=""){
									echo "<a href='AddEditPOI.php?poiID=" . $row['poiID'] . "'> ";
									echo "<img style='width:100px' src='images/" . $row['image'] . "' /> ";
									echo "</a>";
								}
							?>
						</td>
						<!-- The link below will call AddEditPOI with the url parameter delete=true so that the Action page knows that we only need to delete a record -->
						<?php if (isset($_SESSION["isAdmin"]) && $_SESSION["isAdmin"] == 1) { ?>
							<td style='width:100px;text-align:center'> <?php echo "<a href='AddEditPOIAction.php?poiID=" . $row['poiID'] . "&delete=true'> <img src='images/delete.png'/> </a>"; ?> </td>
						<?php } ?>
					</tr>
				<?php } ?>
			</table>
		</div>



	</body>
</html>