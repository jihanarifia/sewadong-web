<!DOCTYPE html>
<html>
<head>
	<title>Upload</title>
</head>
<body>
<form method="post">
	<input type="text" name="image">
	<input type="text" name="name">
	<button type="submit" name="submit"></button>
</form>
</body>
</html>
<?php
if (isset($_POST["submit"])) {
	$base = $_POST["image"];
	$name= $_POST["name"];
	$binary=base64_decode($base);
	header('Content-Type: bitmap; charset=utf-8');
	$file = fopen($name, 'w');
	fwrite($file, $binary);
	fclose($file);

	echo "Avatar changed";
}


?>
