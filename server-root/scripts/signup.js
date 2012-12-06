
/*
 using javascript to do form validation	
 using RegExp to do pattern matching
 Malong	
*/

// Check form (after click submit button) -- Signup form
function validateForm()
{
	var name_expr = /^\w+@\w+\.\w+$/;

	//check First name input field is not empty
	if (document.forms["signupForm"]["firstName"].value==null || document.forms["signupForm"]["firstName"].value=="")
		{
			alert ("First Name Field cannot be blank.");
			document.signupForm.firstName.focus();
			return false;
		}
		
	//check Last name input field is not empty
	if (document.forms["signupForm"]["lastName"].value==null || document.forms["signupForm"]["lastName"].value=="")
		{
			alert ("Last Name Field cannot be blank.");
			document.signupForm.lastName.focus();
			return false;
		}
		
	//check Password input field is not empty AND at least 5 char AND Must be a same password
	if (document.forms["signupForm"]["password"].value==null || document.forms["signupForm"]["password"].value=="")
		{
			alert ("Password Field cannot be blank.");
			document.signupForm.password.focus();
			return false;
		}
	if (document.forms["signupForm"]["password"].value.length < 5)
		{
		     alert("Your password must be at least 5 characters long.");
		 	 document.signupForm.password.focus();
			 return false;
		   }
	if (document.forms["signupForm"]["password"].value !== document.forms["signupForm"]["repassword"].value)
		{
		     alert("Your Password do not match.");
			 document.signupForm.repassword.focus();
			 return false;
		};
	
	//check Eamil address is not empty
	if (document.forms["signupForm"]["emailAddress"].value==null || document.forms["signupForm"]["emailAddress"].value=="")
		{
		     alert("Your EmailAddress cannot be blank.");
			 document.signupForm.emailAddress.focus();
			 return false;
		};
	if (!name_expr.test(document.signupForm.emailAddress.value))
		{		   
              alert("email address format is not correct.");
              document.signupForm.emailAddress.focus();
              return false;
		   };
		   
	//check the phone number is a number ONLY
	if (isNaN(document.signupForm.phoneN.value))
		 {
		      alert("Phone number field must be a number.");
			  document.signupForm.phoneN.focus();
			  return false;
		   }
	
	//tell the user their account has been created, and ready for login
	alert ("Your account has been created, please use the login at the right side");
	
	
	
		
}		 




















