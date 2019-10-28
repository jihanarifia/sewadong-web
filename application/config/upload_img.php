<?php
	header('Content-type: application/json');
	$base = $_POST['image'];
	$name= $_POST['name'];
	$imsrc = str_replace(' ','+',$base);
	$binary = base64_decode($imsrc);

	$file = fopen($name, 'w');
	fwrite($file, $binary);
	if(fclose($file)){
	 	$response = [ 'status' => 'true', 'message' => 'berhasil upload' ];
		echo json_encode($response);
	}else{
		$response = [ 'status' => 'false', 'message' => 'upload gagal' ];
		echo json_encode($response);
	}
?>
