<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
$target_path = "account/";
$target_path = $target_path . basename( $_FILES['file']['name']);

if(move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {
    $status = "success";
    $message = "Upload and move success";
    $err_message = "";
} else {
    $status = "fail";
    $message = "There was an error uploading the file, please try again!";
    $err_message = "Upload fail to path : ".$target_path;
}

$response = array(
    "status" => $status,
    "message" => $message,
    "err_message" => $err_message
);

$res = array();
array_push($res, $response);

$res2 = json_encode($res);

echo $res2;
?>