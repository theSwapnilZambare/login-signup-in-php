<?php 
if(isset($_REQUEST['key']) && !empty($_REQUEST['key']))
{
	include("connection.php");
	
	$email = $_REQUEST['key'];
	$email = base64_decode($email);
	
	$result = mysqli_query($con,"select status,email from users where email='$email'");
	
	if(mysqli_num_rows($result) == 1)
	{
		$row = mysqli_fetch_assoc($result);
		if($row['status'] === "inactive")
		{
			mysqli_query($con,"update users set status = 'active' where email='$email'");
			if(mysqli_affected_rows($con)==1)
			{
				echo "<p>Account activated Successfully</p>";
			}
			else{
				echo "<p>Sorry! Unable to update the status</p>";
				
			}
		}
		else
		{
			echo "<p>Your account is already active</p>";
		}
	}
	else
	{
		echo "<p>Sorry! Unable to Find your account</p>";
	}
	
	
	mysqli_close($con);
}
else
{
	echo "<p>Sorry! UnAuthourised Access...</p>";
}


?>