<h1>Ringmaster</h1>
<h2>Validate your email address</h2>
<p>
	You've signed up for Ringmaster, but haven't yet proven that you own this email address.
	To show us that you do, in fact, own this email, copy the URL below and paste it into your
	browser. 
</p>
<p>
	<em><?php echo action("UserController@validateToken", ['token' => $user->validation_token]);?></em>
</p>
<p>
	If you did not sign up for Ringmaster, don't worry about it, just don't validate the account. 
	Whoever signed up with your email address won't be able to do anything on your behalf.
</p>