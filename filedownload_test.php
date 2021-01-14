<?php
$file = $_GET["path"];
if( !file_exists($file) ) {
	header("HTTP/1.1 404 NOT FOUND");
	exit;
}
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="'.basename($file).'"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($file));
readfile($file);
?>