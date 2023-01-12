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
	$admin_details = $session->get('user_details');
	$firstname = $admin_details[0];
	


	echo "Welcome $firstname";
?>



</body>
</html>