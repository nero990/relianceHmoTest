<?php

function emailChecker($email) {
	$handle = curl_init();
	 
	$url = "http://apilayer.net/api/check?access_key=28b21a1c333999354ecb2a03e365dc0a&email={$email}&smtp=1&format=1";
	 
	// Set the url
	curl_setopt($handle, CURLOPT_URL, $url);
	// Set the result output to be a string.
	curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
	 
	$output = curl_exec($handle);
	 
	curl_close($handle);

	return json_decode($output, true);
}

$response = [];

if(isset($_POST["submit"])){
	$response = emailChecker($_POST["email"]);
}


?>

<!DOCTYPE html>
<html>
<head>
	<title>Validate Email</title>
</head>
<body>

	<?php
		if(!empty($response)) {
			$email_exist = $response["mx_found"] == true ? "YES" : "NO";
			$valid_format = $response["format_valid"] == true ? "YES" : "NO";
			echo "<p><b>Result</b></p>";
			echo "<p> Email: <b>" . $response["email"]. "</b></p>";
			echo "<p> Email Existence: <b>{$email_exist} </b></p>";
			echo "<p> Valid Format: <b>{$valid_format}</b></p>";
			echo "<p> Email Domain: <b>" . $response["domain"]. " </b></p><br><br>";
		}
	?>
	<form action="" method="POST">
		Email : <input type="text" name="email"><br>

		<input type="submit" name="submit" value="Validate">
	</form>
</body>
</html>