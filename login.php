<?php
	session_start();
	// Check if we have already created a authenticated session
	if (isset($_SESSION["authenticatedUser"])) {
		$_SESSION["message"] = "You are already logged in as ". $_SESSION['authenticatedUser'];
	}
?>
<head>
<title>Login Page</title>

	<!-- Include meta elements here!  -->
	<meta charset="UTF-8"/>
	<meta name="author" content="Abdulrahman"/>
	<meta name="description" content="Web Development Project"/>

	<!-- Application custom CSS -->
	<link rel="stylesheet" href="stylesheet.css">

</head>
<body>
	<div class="row">
		<?php include_once("header.php"); ?>
		<h2>Login Page</h2>
		<?php echo "<h3><font color=red>".$_SESSION['message'] . "</font></h3>";
		$_SESSION['message'] = "";
		?>

		<?php if (isset($_SESSION["authenticatedUser"])) { ?>
		<form method="post" action="loginAction.php">
			<input type="hidden" name="signout" value="True" >
			<input name="submit" type="submit" value="Log Out">
		</form>
		<?php } else { ?>
		<table width="76%" border="0">
			<tr>
				<td>
					<form method="post" action="loginAction.php">
						<table>
							<tr>
								<td>To Test Admin</td>
								<td>Username: user@gmail.com <br/> password: User#ame1</td>
							</tr>
							<tr>
								<td>To Test User</td>
								<td>Username: user <br/> password: Test3</td>
							</tr>
							<tr>
								<td>Username</td>
								<td><input type="text" name="username"></td>
							</tr>
							<tr>
								<td>Password:</td>
								<td><input type="password" name="password"></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td><p><input name="submit" type="submit" value="Log in"></td>
							</tr>
						</table>



					</form>
				</td>
				<td>&nbsp;</td>
			</tr>
		</table>
		<?php } ?>
		<p>&nbsp;</p>
	</div>
</body>


<script>
	
	$('.message a').click(function(){
   $('form').animate({height: "toggle", opacity: "toggle"}, "slow");
});
</script>
</html>
