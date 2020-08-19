<?php

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

function generateRandomString($length = 32) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

if($_SERVER['REQUEST_METHOD'] == 'GET') {
    echo "Esta es una solicitud GET sin parametros.\n";
}
else if($_SERVER['REQUEST_METHOD'] == 'POST') {
	$file = "../credential/llavesT.txt";
	$jsonData = json_decode(file_get_contents($file), true);

    //echo "Esta es una solicitud POST.\n";
    parse_str(file_get_contents("php://input"),$post_vars);
    $resArray = array();

	foreach (getallheaders() as $name => $value) { 
		//echo "$name: $value <br>"."\n";
		if($name==="X-Key" || $name==="X-Route" || $name==="X-Signature"){
			$resArray[$name] = $value;
		}		
		if($name==="X-Route"){

		}
	}
	if(count($resArray)==3){
		foreach ($jsonData as $i=> &$row){
			if($i==$resArray['X-Key']){
				//http_response_code(403);
				
				if($row["signature"]==$resArray['X-Signature']){
					echo "Datos validos, guardando mensaje y tags."."\n";
					$savedmsgs = "mensajes.txt";
					$jsonMsgs = json_decode(file_get_contents($savedmsgs), true);
					
					$hasMac = $row["signature"];
					header('Signature: '.$hasMac);
				}
				else{
					http_response_code(403);
					echo "Llave invalida, por favor verificar."."\n";
				}
			}
		}

		//echo count($resArray);
	}
	else{
		http_response_code(403);
		echo "Datos incompletos, por favor proporcione la llave, la ruta y la firma a utilizar."."\n";
	}
	echo json_encode($resArray);
	
    echo json_encode($post_vars);
}

?>