<?php include("connection.php");?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Register Here</title>
		<link href="css/styles.css" rel="stylesheet" />
	</head>
	<body>
		<div class="container">
			<h1>Register Here</h1>
			
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
			
			if(isset($_POST['save']))
			{
				$uname = (isset($_POST['uname'])) ? filterData($_POST['uname']) : "";
				$email = (isset($_POST['email'])) ? filterData($_POST['email']) : "";
				$pass = (isset($_POST['pwd'])) ? filterData($_POST['pwd']) : "";
				$hpass = password_hash($pass,PASSWORD_DEFAULT);
				$mobile = (isset($_POST['mobile'])) ? filterData($_POST['mobile']) : "";
				$gender = (isset($_POST['gender'])) ? filterData($_POST['gender']) : "";
				$ip = $_SERVER['REMOTE_ADDR'];
				
				mysqli_query($con,"INSERT INTO users(username,email,password,mobile,gender,ip) VALUES('$uname','$email','$hpass','$mobile','$gender','$ip')");
				
				if(mysqli_affected_rows($con)==1)
				{
					$token = base64_encode($email);
					$subject = "Account Activation";
					$message = "Hi ".$uname."<br>, Thanks Your account created successfully. Please click the below link to activate your account.<br><br><a href='http://localhost/login-signup-in-php/activate.php?key=".$token."' target='_blank'>Activate Now</a><br><br>Thanks<br>Team";
					
					$mheaders = "Content-Type:text/html";
					
					if(mail($email, $subject, $message, $mheaders))
					{
						setcookie("success","Account Created successfully. Please activate your account", time()+3);
						header("Location: register.php");
					}
					else
					{
						setcookie("error","Account Created successfully, Unable to sent activation link, contact Admin", time()+3);
						header("Location: register.php");
					}
					
				}
				else
				{
					//echo mysqli_error($con);
					setcookie("error","Sorry Unable to create an account", time()+3);
					header("Location: register.php");
				}
				
				
			}
			?>
			
			<form autocomplete="off" method="POST" action="" onsubmit="return registerValidate()">
				
				<div class="formgroup">
					<label>UserName:</label>
					<input type="text" onfocus="hideError(this)" onblur="checkError(this)" name="uname" id="uname" class="formcontrol"/>
					<small class="errormsg" id="uname_error"></small>
				</div>
				
				<div class="formgroup">
					<label>Email:</label>
					<input type="email" onfocus="hideError(this)" onblur="checkError(this)" name="email" id="email" class="formcontrol"/>
					<small class="errormsg" id="email_error"></small>
				</div>
				
				<div class="formgroup">
					<label>Password:</label>
					<input type="password" name="pwd" id="pwd" class="formcontrol"/>
					<small class="errormsg" id="pwd_error"></small>
				</div>
				
				<div class="formgroup">
					<label>Confirm Password:</label>
					<input type="password" name="cpwd" id="cpwd" class="formcontrol"/>
					<small class="errormsg" id="cpwd_error"></small>
				</div>
				
				<div class="formgroup">
					<label>Mobile:</label>
					<input type="number" name="mobile" id="mobile" class="formcontrol"/>
				</div>
				
				<div class="formgroup">
					<label>Gender:</label>
					<label><input name="gender" type="radio" value="Male" /> Male</label>
					<label><input name="gender" type="radio" value="Female"/> Female</label>
				</div>

				<div class="formgroup">
					<input type="submit" name="save" value="Register" class="btn"/>
				</div>
				
			</form>
				<div class="formgroup">
					<a href="login.php" class="btn">Login</a>
				</div>
		</div>
		
		<script>
			function registerValidate()
			{
				var formStatus = true;
				
				var uname = document.getElementById("uname");
				if(uname.value === "")
				{
					uname.style.cssText = "border:2px solid tomato";
					document.getElementById(uname.id+"_error").innerText = "This field is required";
					formStatus = false;
				}
				
				var email = document.getElementById("email");
				if(email.value === "")
				{
					email.style.cssText = "border:2px solid tomato";
					document.getElementById(email.id+"_error").innerText = "This field is required";
					formStatus = false;
				}
				else{
					if(!validateEmail(email.value))
					{
						email.style.cssText = "border:2px solid tomato";
						document.getElementById(email.id+"_error").innerText = "Please enter valid email";
						formStatus = false;
					}
				}
				
				var pwd = document.getElementById("pwd");
				var cpwd = document.getElementById("cpwd");
				
				if(pwd.value === "")
				{
					pwd.style.cssText = "border:2px solid tomato";
					document.getElementById(pwd.id+"_error").innerText = "This field is required";
					formStatus = false;
				}
				if(cpwd.value === "")
				{
					cpwd.style.cssText = "border:2px solid tomato";
					document.getElementById(cpwd.id+"_error").innerText = "This field is required";
					formStatus = false;
				}
				
				if(pwd.value !== cpwd.value)
				{
					alert("Passwords does not matched")
					formStatus = false;
				}
				
				return formStatus;
				
			}
			
			function validateEmail(email) {
				const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
				return re.test(String(email).toLowerCase());
			}
			
			function hideError(element)
			{
				if(element.value === "")
				{
					element.style.cssText = "border: 2px solid #333";
					document.getElementById(element.id+"_error").innerText = "";
				}
			}
			
			function checkError(element)
			{
				if(element.value === "")
				{
					element.style.cssText = "border: 2px solid tomato";
					document.getElementById(element.id+"_error").innerText = "This Field is required";
				}
			}
		</script>
	</body>
</html>
<?php mysqli_close($con);?>