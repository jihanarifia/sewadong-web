<?php
	header('Content-type: application/json');
	$photo = $_POST['image'];
   	if (file_exists($photo)) {
   		chmod($photo, 0644);
   		unlink($photo);
	 	$response = [ 'status' => 'true', 'message' => 'berhasil hapus' ];
		echo json_encode($response);
	} 
	else {
    	$response = [ 'status' => 'false', 'message' => 'hapus gagal' ];
		echo json_encode($response);
	}
?>