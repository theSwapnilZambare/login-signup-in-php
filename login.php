<?php 
session_start();
include("connection.php");?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
    	<title>Login Here</title>
		<link href="css/styles.css" rel="stylesheet" />
	</head>
	<body>
		<div class="container">
			<h1>Login Here</h1>
			
			<?php 
			
			if(isset($_COOKIE['success']))
			{
				echo "<p>".$_COOKIE['success']."</p>";
			}
			if(isset($_COOKIE['error']))
			{
				echo "<p>".$_COOKIE['error']."</p>";
			}
			
			function filterData($data)
			{
				return addslashes(strip_tags(trim($data)));
			}
			if(isset($_POST['login']))
			{
				$email = (isset($_POST['email'])) ? filterData($_POST['email']) : "";
				$pass = (isset($_POST['pwd'])) ? filterData($_POST['pwd']) : "";
				
				$result = mysqli_query($con,"select *from users where email='$email'");
				
				if(mysqli_num_rows($result)==1)
				{
					$row = mysqli_fetch_assoc($result);
					if(password_verify($pass, $row['password']))
					{
						if($row['status'] == "active")
						{
							$_SESSION["userid"] = $row['id'];
							header("Location:home.php");
						}
						else
						{
							echo "<p>Please activate your account<p>";
						}
					}
					else
					{
						echo "<p>Sorry! Wrong credentials entered</p>";
					}
				}
				else
				{
					echo "<p>Sorry! Unable to find your account</p>";
				}
				
			}
			?>
			
			
			<form method="POST" action="" onsubmit="return loginValidate()">
				<div class="formgroup">
					<label>Email:</label>
					<input type="email" onfocus="hideError(this)" onblur="checkError(this)" name="email" id="email" class="formcontrol"/>
					<small class="errormsg" id="email_error"></small>
				</div>
				
				<div class="formgroup">
					<label>Password:</label>
					<input onfocus="hideError(this)" onblur="checkError(this)" type="password" name="pwd" id="pwd" class="formcontrol"/>
					<small class="errormsg" id="pwd_error"></small>
				</div>

				<div class="formgroup">
					<input type="submit" name="login" value="Login" class="btn"/>
				</div>
				
				<div class="formgroup">
					<a href="forgot.php">Forgot Password ?</a> | <a href="register.php">Create an Account</a>
				</div>
				
			</form>
		</div>
		<script src="js/validations.js"></script>
	</body>
</html>
<?php mysqli_close($con);?>
