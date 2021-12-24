<?php
session_start();
if(isset($_SESSION["userid"]) && !empty($_SESSION["userid"]))
{
	include("connection.php");
	$id = $_SESSION['userid'];
	$result = mysqli_query($con,"select username,profile from users where id=$id");
	$row = mysqli_fetch_assoc($result);
	?>
	<!DOCTYPE html>
	<html lang="en">
		<head>
			<meta charset="UTF-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title><?php echo ucwords($row['username']);?> | Upload Avatar</title>
			<link href="css/styles.css" rel="stylesheet" />
		</head>
		<body>
			<div class="container">
				<?php include("menu.php");?>
				<h1><?php echo ucwords($row['username']);?> | Upload Avatar</h1>
				
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
				
				if(isset($_POST['upload']))
				{
					if(is_uploaded_file($_FILES['avatar']['tmp_name']))
					{
						$filename = $_FILES['avatar']['name'];
						$filesize = $_FILES['avatar']['size'];
						$filetype = $_FILES['avatar']['type'];
						$tmpname = $_FILES['avatar']['tmp_name'];
						$errorno = $_FILES['avatar']['error'];
						$allowed_types = ["image/png","image/jpg","image/gif","image/jpeg"];
						
						if(in_array($filetype, $allowed_types))
						{
							if(file_exists("profiles/$filename"))
							{
								$str = substr(str_shuffle('qwertyuioplkjhgfdsazxcvbnm'),6,15);
								$filename = $str."_".time()."_".$filename;
							}
							
							if(move_uploaded_file($tmpname,"profiles/$filename"))
							{
								mysqli_query($con,"update users set profile='$filename' where id=$id");
								if(mysqli_affected_rows($con)==1)
								{
									setcookie("success","File Uploaded successfully",time()+3);
									header("Location: avatar.php");
								}
								else
								{
									setcookie("error","Sorry! Unable to upload. Try again",time()+3);
							header("Location: avatar.php");
								}
							}
							else
							{
								setcookie("error","Sorry! Unable to upload a file",time()+3);
								header("Location: avatar.php");
							}
						}
						else{
							setcookie("error","Please select a valid image to upload",time()+3);
							header("Location: avatar.php");
						}
						
						
					}
					else
					{
						setcookie("error","Please select an image to upload",time()+3);
						header("Location: avatar.php");
					}
				}
				?>
				
				<form method="POST" action="" enctype="multipart/form-data">
					<div class="formgroup">
						<label>Upload Profile Picture:</label>
						<input type="file" name="avatar" class="formcontrol" />
					</div>
					
					<div class="formgroup">
						<input type="submit" name="upload" value="Upload" class="btn"/>
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

