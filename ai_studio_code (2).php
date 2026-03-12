<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: text/plain'); // Evita algunos inyectores de ads

$file = __DIR__ . '/data_ruteo.json';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir los datos ocultos en Base64 para burlar el Firewall 502 de Miarroba
    if(isset($_POST['b64data'])) {
        $json = base64_decode($_POST['b64data']);
        if($json !== false && file_put_contents($file, $json) !== false) {
            echo '---START_JSON---{"status":"success"}---END_JSON---';
        } else {
            echo '---START_JSON---{"error":"Permisos"}---END_JSON---';
        }
    } else {
        echo '---START_JSON---{"error":"Vacio"}---END_JSON---';
    }
} else {
    // Envolvemos los datos limpios para que JS ignore los anuncios de Miarroba
    echo "---START_JSON---";
    if (file_exists($file)) {
        echo file_get_contents($file);
    } else {
        echo '{}';
    }
    echo "---END_JSON---";
}
die();
?>