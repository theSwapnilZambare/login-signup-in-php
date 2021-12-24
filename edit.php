<?php 
session_start();
if(isset($_SESSION["userid"]) && !empty($_SESSION["userid"]))
{
	include("connection.php");
	$id = $_SESSION['userid'];
	$result = mysqli_query($con,"select username,mobile,gender,profile from users where id=$id");
	$row = mysqli_fetch_assoc($result);
	?>
		<!DOCTYPE html>
		<html lang="en">
			<head>
				<meta charset="UTF-8">
				<meta http-equiv="X-UA-Compatible" content="IE=edge">
				<meta name="viewport" content="width=device-width, initial-scale=1.0">
				<title><?php echo ucwords($row['username']);?> | Edit Profile</title>
				<link href="css/styles.css" rel="stylesheet" />
			</head>
			<body>
				<div class="container">
					<?php include("menu.php");?>
					<h1><?php echo ucwords($row['username']);?> | Edit Profile</h1>
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
				if(isset($_POST['save']))
				{
					$uname = (isset($_POST['uname'])) ? filterData($_POST['uname']) : "";
					$mobile = (isset($_POST['mobile'])) ? filterData($_POST['mobile']) : "";
					$gender = (isset($_POST['gender'])) ? filterData($_POST['gender']) : "";
					
					mysqli_query($con,"update users set username='$uname', mobile='$mobile', gender='$gender' where id=$id");
					
					if(mysqli_affected_rows($con)==1)
					{
						setcookie("success","Profile Updated successfully",time()+2);
						header("Location: edit.php");
					}
					else
					{
						setcookie("error","Unable to update profile. Try again.",time()+2);
						header("Location: edit.php");
					}
					
				}
				?>
				<form autocomplete="off" method="POST" action="" onsubmit="return editValidate()">
					<div class="formgroup">
						<label>UserName:</label>
						<input type="text" onfocus="hideError(this)" onblur="checkError(this)" name="uname" id="uname" class="formcontrol" value="<?php echo $row['username'];?>" />
						<small class="errormsg" id="uname_error"></small>
					</div>
					
					<div class="formgroup">
						<label>Mobile:</label>
						<input type="number" name="mobile" onfocus="hideError(this)" onblur="checkError(this)" id="mobile" value="<?php echo $row['mobile'];?>" class="formcontrol"/>
						<small class="errormsg" id="mobile_error"></small>
					</div>
					
					<div class="formgroup">
						<label>Gender:</label>
						<label><input name="gender" <?php if($row['gender'] == "Male") echo "checked"; ?> type="radio" value="Male" /> Male</label>
						<label><input name="gender" <?php if($row['gender'] == "Female") echo "Checked"; ?> type="radio" value="Female"/> Female</label>
					</div>

					<div class="formgroup">
						<input type="submit" name="save" value="Update" class="btn"/>
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
?>