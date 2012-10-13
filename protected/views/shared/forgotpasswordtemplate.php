<?php
 /** variables
  * @var password The new password for the account.
  * @var membershipId The ID number of the membership (the username)
  */
?>
<h3>Reset password for Swedish Club of WA</h3>
<p>Your account password has been reset. You may now login using the following credentials</p>
<p>
	Username: <strong><?php echo $membershipId; ?></strong><br/>
	Password: <strong><?php echo $password; ?></strong>
</p>
<p>
It is highly recommended that you change your password after logging in with the above credentials. 
</p>
<a href="http://svenskaklubben.org.au/club-membership-application/site/login" title="Swedish Club of WA - Login" target="_blank">Swedish Club of WA - Login</a>