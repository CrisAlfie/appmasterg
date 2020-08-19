<?php
if($_SERVER['REQUEST_METHOD'] == 'GET') {
    echo "Esta es una solicitud GET sin parametros.\n";
}
else if($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo "Esta es una solicitud POST sin parametros obtenidos.\n";
}

?>