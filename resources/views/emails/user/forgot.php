<h1>Ringmaster</h1>
<h2>Reset your password</h2>
<p>
	You (or someone) has requested that the Ringmaster password associated with this email
	address be reset. If it wasn't you, then someone is up to something, but you can ignore 
	this email. If it was you, congratulations! Your memory sucks. This time come up with a
	password you'll remember. 
</p>
<p>
	Open this link in your browser to reset your password.
</p>
<p>
	<em><?php echo action("UserController@forgotToken", $user->forgot_token);?></em>
</p>