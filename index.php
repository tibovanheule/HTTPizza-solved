<?php
ini_set('max_execution_time', 300);
const MAXLINE = 2000;
require_once 'connect.class.php';
require_once 'parser.class.php';
$connect = new Connect();
$parser = new parser();
$buffer = $connect->serverconnect("PIZZA /welcome\n\n");
echo "<br/>";
$buffer = $connect->serverconnect("ORDER /login\nname => tibi\n\n");
$table = $parser->get_header($buffer, 'Table');
echo "The table is: " . $table . "<br/>";
$buffer = $connect->serverconnect("PIZZA /menu\nTable => $table\n\n");
$body = $parser->json($buffer);
$json = json_decode($body);
$combinations = $parser->combination($json->topping);
foreach ($combinations as $value) {
    if (count($value) > 2) {
        $json = "{\"topping\":" . json_encode($value) . ",\"sauce\":[\"bbq\"]}";
        $result = $connect->bruteforce("PIZZA /pizza\nTable => $table\nI-Want => $json\n\n");
        if ($result) {
            echo "Bestaat! :" . $json;
            echo "<br/>";
        }
        $json = "{\"topping\":" . json_encode($value) . ",\"sauce\":[]}";
        $result = $connect->bruteforce("PIZZA /pizza\nTable => $table\nI-Want => $json\n\n");
        if ($result) {
            echo "Bestaat! :" . $json;
            echo "<br/>";
        }

    }
}