<?php 
session_start();
if(isset($_SESSION["userid"]) && !empty($_SESSION["userid"]))
{
	include("connection.php");
	$id = $_SESSION["userid"];
	$result = mysqli_query($con,"select *from users where id=$id");
	$row = mysqli_fetch_assoc($result);
	?>
	<!DOCTYPE html>
	<html lang="en">
		<head>
			<meta charset="UTF-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title>Welcome to <?php echo ucwords($row['username']);?></title>
			<link href="css/styles.css" rel="stylesheet" />
		</head>
		<body>
			<div class="container">
			
				<?php include("menu.php");?>
			
				<h1>Welcome to <?php echo ucwords($row['username']);?></h1>
				
				<?php 
				if($row['profile'] != "")
				{
					?>
					<img src="profiles/<?php echo $row['profile'];?>" height="100" width="100" />
					<?php
				}
				?>
				
				<table border="1" id="customers">
					<tr>
						<td>ID</td>
						<td><?php echo $row['id'];?></td>
					</tr>
					<tr>
						<td>UserName</td>
						<td><?php echo ucwords($row['username']);?></td>
					</tr>
					<tr>
						<td>Email</td>
						<td><?php echo $row['email'];?></td>
					</tr>
					<tr>
						<td>Mobile</td>
						<td><?php echo $row['mobile'];?></td>
					</tr>
					<tr>
						<td>Date of Joining</td>
						<td><?php echo date("l, dS M Y",strtotime($row['created_at']));?></td>
					</tr>
				</table>
			</div>
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