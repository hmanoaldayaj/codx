<!doctype html>
<?php
	session_start();
?>
<html lang="en">
	<head>

		<title>Signup</title>
		<!-- Include meta elements here!  -->
		<meta charset="UTF-8"/>
		<meta name="author" content="Abdulrahman"/>
		<meta name="description" content="Web Development Project"/>

		<!-- Application custom CSS -->
		<link rel="stylesheet" href="stylesheet.css">

		<script>
			//email validation using javascript - client side validation.
			function validateEmail() {
				email = $("#email").val();

				re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
				valid = re.test(email);//regular expression to validate email address

				if (valid == true) {
					return true;
				} else {
					alert("The email you provided '"+ email + "' is not valid. Please correct it and save again.");
					return false;
				}

			}

			function allFields() {
				if($("#username").val()!="" && $("#password").val()!="" && $("#firstName").val()!="" && $("#lastName").val()!="" && $("#email").val()!="")
					return true;
				else
					alert("All fields in the signup form should be completed");
			}

			//Password validation using javascript - client side validation.
			function validatePwd() {
				pwd = $("#password").val();

				b=0, c=0, d=0;
				for(i=0;i<pwd.length;i++){
					if('A' <= pwd[i] && pwd[i] <= 'Z') // check if you have an uppercase
						b++;
					if('a' <= pwd[i] && pwd[i] <= 'z') // check if you have a lowercase
						c++;
					if('0' <= pwd[i] && pwd[i] <= '9') // check if you have a numeric
						d++;
    			}
				if(b>0 && c>0 && d>0){
					return true;
				} else {
					alert("The password you provided '"+ pwd + "' is not valid. It should contain at least one uppercase, one lowercase and a numeric character.");
					return false;
				}

			}

			function validate(){
				if(allFields() && validateEmail() && validatePwd()){
					return true;
				}
				return false;
			}
		</script>
	</head>
	<body>
		<?php include_once("header.php"); ?>
        <div class="row">
        	<h1>Complete your profile</h1>

        	<div id="errorMessage">
        		<?php echo "<h3><font color=red>".$_SESSION['message']."</font></h3>";
        		$_SESSION["message"] = ""; ?>
        	</div>

		<form method="post" action="signupAction.php" onsubmit="return validate();">
				<div>
					<ul>
						<li class="field">
							<div> Username </div>
							<input id="username" name="username" type="text"/>
						</li>
						<li class="field">
							<div> Password </div>
							<input id="password" name="password" type="text"/>
						</li>
						<li class="field">
							<div> First Name </div>
							<input id="firstName" name="firstName" type="text"/>
						</li>
						<li class="field">
							<div> Last Name </div>
							<input id="lastName" name="lastName" type="text"/>
						</li>
						<li class="field">
							<div> Email </div>
							<input class="narrow text input" id="email" name="email" type="text"/>
						</li>
						<?php if (isset($_SESSION["isAdmin"]) && $_SESSION["isAdmin"] == 1) { ?>
						<li class="field">
							<div> Admin </div>
							<select class="narrow text input" id="isAdmin" name="isAdmin" />
								<option value="0" selected>No</option>
								<option value="1">Yes</option>
							</select>
						</li>
						<?php } else { ?>
							<input type="hidden" id="isAdmin" name="isAdmin" value="0"/>
						<?php } ?>
					</ul>
					<div>
						<a><input type="Submit" value="Save"/></a>
					</div>
				</div>
			<br/><br/>
		</form>
		<?php include_once("footer.php"); ?>
	</body>
</html>