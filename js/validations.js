//Register Validate
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

//Login Validate
function loginValidate()
{
	let formStatus = true;
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
	if(pwd.value === "")
	{
		pwd.style.cssText = "border:2px solid tomato";
		document.getElementById(pwd.id+"_error").innerText = "This field is required";
		formStatus = false;
	}
	return formStatus;
}

// Forgot Validations
function forgotValidate()
{
	let formStatus = true;
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
	return formStatus;
}

// Reset Password validation
function resetValidate()
{
	let formStatus = true;
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

// Edit Form Validation
function editValidate()
{
	var formStatus = true;
	
	var uname = document.getElementById("uname");
	if(uname.value === "")
	{
		uname.style.cssText = "border:2px solid tomato";
		document.getElementById(uname.id+"_error").innerText = "This field is required";
		formStatus = false;
	}
	
	var mobile = document.getElementById("mobile");
	if(mobile.value === "")
	{
		mobile.style.cssText = "border:2px solid tomato";
		document.getElementById(mobile.id+"_error").innerText = "This field is required";
		formStatus = false;
	}
	
	return formStatus;
	
}

// change password form valdation
function changepwdValidate()
{
	let formStatus = true;
	
	var opwd = document.getElementById("opwd");
	var pwd = document.getElementById("npwd");
	var cpwd = document.getElementById("cnpwd");
	
	if(opwd.value === "")
	{
		opwd.style.cssText = "border:2px solid tomato";
		document.getElementById(opwd.id+"_error").innerText = "This field is required";
		formStatus = false;
	}
	
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