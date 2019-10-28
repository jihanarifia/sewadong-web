<?php

$error = false;
if(isset($_FILES['imagetoresize']))
{
	if(is_file($_FILES['imagetoresize']['tmp_name']))
	{
		define('DESTINATION', 'images/');
		define('RESIZEBY', 'w');
		define('RESIZETO', 220);
		define('QUALITY', 100);
		
		require_once 'image.class.php';
		
		$image = new Image($_FILES['imagetoresize']['tmp_name']);
		
		$image->destination = DESTINATION.$_FILES['imagetoresize']['name'];
		$image->constraint = RESIZEBY;
		$image->size = RESIZETO;
		$image->quality = QUALITY;
		
		$image->render();
	
	}
	else
	{
		$error = true;
	}
}

?>