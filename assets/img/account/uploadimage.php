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

	$fname = filter_input(INPUT_POST, "name");
	$name = $fname . ".png";
	//$img = filter_input(INPUT_POST, "image");
	$img = base64_encode(file_get_contents('rare.png'));
	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$img = base64_decode($img);

	file_put_contents($name, $img);

	print "Image has been saved!";
}
?>
