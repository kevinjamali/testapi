<?php
use PhpParser\Node\Stmt\Switch_;
include '_functions.php';
header ( "Content-Type: application/json; charset=UTF-8" );

$from = null;
$to = null;
$type = null;
$convertparam = null;

// read the requests in get method
if (isset ( $_GET ["from"] )) {
	$from = $_GET ["from"];
}
if (isset ( $_GET ["to"] )) {
	$to = $_GET ["to"];
}
if (isset ( $_GET ["type"] )) {
	$type = strtolower ( trim ( $_GET ["type"] ) );
}

if (isset ( $_GET ["convertparam"] )) {
	$convertparam = strtolower ( trim ( $_GET ["convertparam"] ) );
}

// read the requests in post method

if (isset ( $_POST ["from"] )) {
	$from = $_POST ["from"];
}
if (isset ( $_POST ["to"] )) {
	$to = $_POST ["to"];
}
if (isset ( $_POST ["type"] )) {
	$type = strtolower ( trim ( $_POST ["type"] ) );
}
if (isset ( $_POST ["convertparam"] )) {
	$convertparam = strtolower ( trim ( $_POST ["convertparam"] ) );
}

$myJSON = json_encode ( finder ( $from, $to, $type, $convertparam ) );
echo $myJSON;


?>