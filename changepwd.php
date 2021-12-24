<?php
session_start();
if(isset($_SESSION["userid"]) && !empty($_SESSION["userid"]))
{
	include("connection.php");
	$id = $_SESSION['userid'];
	$result = mysqli_query($con,"select username,password,profile from users where id=$id");
	$row = mysqli_fetch_assoc($result);
	?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title><?php echo ucwords($row['username']);?> | Change Password</title>
		<link href="css/styles.css" rel="stylesheet" />
		</head>
		<body>
			<div class="container">
				<?php include("menu.php");?>
				<h1><?php echo ucwords($row['username']);?> | Change Password</h1>
				<?php 
				if($row['profile'] != "")
				{
					?>
					<img src="profiles/<?php echo $row['profile'];?>" height="100" width="100" />
					<?php
				}
				?>
				
				
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
				if(isset($_POST['update'])){
					
					$opass = (isset($_POST['opwd'])) ? filterData($_POST['opwd']) : "";
					$npass = (isset($_POST['npwd'])) ? filterData($_POST['npwd']) : "";
					$hpass = password_hash($npass,PASSWORD_DEFAULT);
					if(password_verify($opass, $row['password']))
					{
						mysqli_query($con,"update users set password='$hpass' where id=$id");
						if(mysqli_affected_rows($con)==1)
						{
							setcookie("success","Password updated successfully",time()+3);
							header("Location: changepwd.php");
						}
						else
						{
							setcookie("error","Sorry! Unable to update password",time()+3);
							header("Location: changepwd.php");
						}
					}
					else
					{
						setcookie("error","Old password does not matched with records",time()+3);
						header("Location: changepwd.php");
					}
					
				}
				?>
				
				
				<form method="POST" action="" onsubmit="return changepwdValidate()">
					<div class="formgroup">
						<label>Old Password</label>
						<input type="password" name="opwd" id="opwd" class="formcontrol" />
						<small class="errormsg" id="opwd_error"></small>
					</div>
					<div class="formgroup">
						<label>New Password</label>
						<input type="password" name="npwd" id="npwd" class="formcontrol" />
						<small class="errormsg" id="npwd_error"></small>
					</div>
					<div class="formgroup">
						<label>Confirm New Password</label>
						<input type="password" name="cnpwd" id="cnpwd" class="formcontrol" />
						<small class="errormsg" id="cnpwd_error"></small>
					</div>
					<div class="formgroup">
						<input type="submit" name="update" value="Update" class="btn" />
					</div>
				</form>
			</div>
			<script src="js/validations.js"></script>
		</body>
	</html>
	<?php
	mysqli_close($con);
}
else
{
	header("Location:login.php");
}

