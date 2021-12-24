<?php 
session_start();
if(isset($_SESSION["userid"]) && !empty($_SESSION["userid"]))
{
	session_unset();
	session_destroy();
	header("location:login.php");
}
else
{
	header("location:login.php");
}