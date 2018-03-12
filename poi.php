<?php
	include_once("header.php");
	include_once("connection.php");
	$query = "SELECT * FROM brand";
	$result = mysqli_query($connection, $query)  or exit ("Error in query: $query. ".mysqli_error());

	while ($row = mysqli_fetch_assoc($result))    { ?>
	<div class="row">
		<div class="four columns">
			<div class="row"><img src="images/<?php echo $row['BrandLogo']; ?>" height="200" width="200" alt="<?php echo $row['BrandName']; ?>"/></div>
		</div>
		<div class="eight columns">
			<p class="brandName"><?php echo $row['BrandName']; ?></p>
			<div class="row">
				<p>
					<?php echo $row['BrandDescription']; ?>
				</p>
			</div>
		</div>
	</div>
	<br/>