<?php 
if(isset($_REQUEST['key']) && !empty($_REQUEST['key']))
{
	include("connection.php");
	$email = base64_decode($_REQUEST['key']);
	
	$result = mysqli_query($con,"select email from users where email = '$email'");
	if(mysqli_num_rows($result)==1)
	{
		?>
			<!DOCTYPE html>
			<html lang="en">
				<head>
					<meta charset="UTF-8">
					<meta http-equiv="X-UA-Compatible" content="IE=edge">
					<meta name="viewport" content="width=device-width, initial-scale=1.0">
					<link href="css/styles.css" rel="stylesheet"/>
				</head>
				<body>
					<div class="container">
						<h1>Reset Password</h1>
						
						<?php 
						if(isset($_COOKIE['success']))
						{
							echo "<p class='success'>".$_COOKIE['success']."</p>";
						}
						if(isset($_COOKIE['error']))
						{
							echo "<p class='error'>".$_COOKIE['error']."</p>";
						}
						
						function filterData($data)
						{
							return addslashes(strip_tags(trim($data)));
						}
						
						
						if(isset($_POST['submit']))
						{
							$pass = (isset($_POST['pwd'])) ? filterData($_POST['pwd']) : "";
							$hpass = password_hash($pass,PASSWORD_DEFAULT);
							mysqli_query($con,"update users set password='$hpass' where email='$email'");
							if(mysqli_affected_rows($con)==1)
							{
								setcookie("success","Password updated successfully. Please Login",time()+3);
								header("Location:login.php");
							}
							else
							{
								setcookie("error","Sorry! Unable to reset password",time()+3);
								header("Location:login.php");
							}
						}
						?>
						
						<form method="POST" action="" onsubmit="return resetValidate()">
							<div class="formgroup">
								<label>New Password:</label>
								<input onfocus="hideError(this)" onblur="checkError(this)" type="password" name="pwd" id="pwd" class="formcontrol"/>
								<small class="errormsg" id="pwd_error"></small>
							</div>
							<div class="formgroup">
								<label>Confirm New Password:</label>
								<input onfocus="hideError(this)" onblur="checkError(this)" type="password" name="cpwd" id="cpwd" class="formcontrol"/>
								<small class="errormsg" id="cpwd_error"></small>
							</div>
							<div class="formgroup">
								<input type="submit" name="submit" value="Update" class="btn"/>
							</div>
						</form>
					</div>
					<script src="js/validations.js"></script>
				</body>
			</html>
		<?php
	}
	else
	{
		echo "<p>Sorry! Unable to find your account</p>";
	}
	
	mysqli_close($con);
}
else
{
	header("Location:login.php");
}
?>