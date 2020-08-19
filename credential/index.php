<?php

header("HTTP/1.0 416 Validando datos");

// session_start();
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

if($_SERVER['REQUEST_METHOD'] == 'GET') {
    echo "this is a get request\n";
    echo $_GET['fruit']." is the fruit\n";
    echo "I want ".$_GET['quantity']." of them\n\n";
} elseif($_SERVER['REQUEST_METHOD'] == 'PUT') {
    echo "this is a put request\n";
    http_response_code(400);
    var_dump(http_response_code(416));
    parse_str(file_get_contents("php://input"),$post_vars);

	$user = "bross";
	$first = "Bob";
	$last = "Ross";

	$file = "llavesT.txt";
	$json = json_decode(file_get_contents($file), true);



	$json[$user] = array("first" => $first, "last" => $last);
	echo $post_vars;
    echo "\n\n".$post_vars['key']." es la llave\n";
    //echo "I want ".$post_vars['quantity']." of them\n\n";
}

?>