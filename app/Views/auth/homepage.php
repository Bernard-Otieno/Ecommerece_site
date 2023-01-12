<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title> homepage</title>
</head>
<body>
<h1> homepage</h1>
	<?php 
	$session = session();
	$user_details = $session->get('user_details');
	$firstname = $user_details[0];
	$lastname = $user_details[1];
	$fullname = $firstname." ".$lastname;

	echo "Welcome $fullname";






	?>



</body>
</html>