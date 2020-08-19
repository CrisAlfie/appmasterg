<?php

header("HTTP/1.0 416 Validando datos");

// session_start();
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

if($_SERVER['REQUEST_METHOD'] == 'GET') {
    echo "this is a get request\n";
    echo $_GET['key']." is the key\n";
    echo $_GET['shared_secred']." shhhhhhh\n\n";
} elseif($_SERVER['REQUEST_METHOD'] == 'PUT') {
    echo "Verificando datos...\n";
    http_response_code(416);
    //var_dump(http_response_code(416));
    parse_str(file_get_contents("php://input"),$post_vars);

	$user = "bross";
	$first = "Bob";
	$last = "Ross";

	$file = "llavesT.txt";
	$jsonData = json_decode(file_get_contents($file), true);
	if(array_key_exists("key", $post_vars) && array_key_exists("shared_secret", $post_vars)){
		foreach ($jsonData as $i=> &$row){
			if($i==$post_vars['key']){
				http_response_code(403);
				echo "Llave en uso, por favor verificar"."\n";
			}
		}
		if(http_response_code()==416){
			$string = "";
			$resArray = array();
			
			foreach (getallheaders() as $name => $value) { 
				if($name==="X-Route"){
					$resArray[$name] = $value;
					//echo "$name: $value <br>"."\n";
				}
			} 

			if(count($_GET)) {
				foreach ($_GET as $name => $value) { 
					$resArray[$name] = $value;
				}
			     //some parameters are set
				//var_dump($_GET);
			}

			foreach ($post_vars as $name => $value) { 
				$resArray[$name] = $value;
				//echo "$name: $value <br>"."\n";
			}
			natsort($resArray);
			foreach ($resArray as $name => $value) {
				$string = $string.$name.";".$value.";";
			}
			//var_dump($resArray);
			echo $string."\n";
			$hasMac = hash_hmac('sha256', $string, $post_vars['shared_secret']);

			echo $hasMac."\n";
			echo( http_response_code() )."\n";
		}
		
	}
	else{
		http_response_code(400);
		echo "Datos no validos, por favor proporcione los parametros 'key' y 'shared_secret'"."\n";
	}

	//$jsonData[$user] = array("first" => $first, "last" => $last);

	//echo json_encode($post_vars);
    //echo "I want ".$post_vars['quantity']." of them\n\n";
}

?>