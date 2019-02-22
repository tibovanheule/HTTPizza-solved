<?php
ini_set('max_execution_time', 300);
const MAXLINE = 2000;
require_once 'connect.class.php';
require_once 'parser.class.php';
$connect = new Connect();
$parser = new parser();
$buffer = $connect->serverconnect("PIZZA /welcome\n\n");
echo "<pre>";
print_r($buffer);
echo "</pre>";
echo "<br/>";
$buffer = $connect->serverconnect("ORDER /login\nname => tibi\n\n");
$table = $parser->get_header($buffer, 'Table');
echo "The table is: " . $table . "<br/>";
echo "<pre>";
print_r($buffer);
echo "</pre>";
echo "<br/>";
$buffer = $connect->serverconnect("PIZZA /menu\nTable => $table\n\n");
echo "<pre>";
print_r($buffer);
echo "</pre>";
echo "<br/>";
$body = $parser->json($buffer);
$json = json_decode($body);
$combinations = $parser->combination($json->topping);
$type = "";
/*
foreach ($combinations as $value) {
    if (count($value) > 2) {
        $json = "";
        foreach ($value as $value2) {
            $json .= ", topping/".$value2;
        }
        $json = ltrim($json,", ");
        $result = $connect->bruteforce("PIZZA /pizza\nTable => $table\nI-Want => $json\n\n");
        if(strpos($result, '200') !== false) {
            echo "<pre>";
            print_r($result);
            echo "</pre>";
            echo "<br/>";

            $type = $parser->get_header($result,"Pizza-Type");
        }
        $json .= ", sauce/bbq";
        $result = $connect->bruteforce("PIZZA /pizza\nTable => $table\nI-Want => $json\n\n");
        if(strpos($result, '200') !== false) {
            echo "<pre>";
            print_r($result);
            echo "</pre>";
            echo "<br/>";

            $type = $parser->get_header($result,"Pizza-Type");
        }
    }
}
*/


$result = $connect->serverconnect("ORDER /order\nTable => $table\nPizza-Type => chicken bbq\n\n");
echo "<pre>";
print_r($result);
echo "</pre>";
echo "<br/>";
$time = trim($parser->get_header($result, "Oven-Time"));
echo "Oven-time: " . $time;
sleep($time);
$id = trim($parser->get_header($result, "Pizza-id"));
$result = $connect->serverconnect("ORDER /pickup\nTable => $table\n\n");
echo "<pre>";
print_r($result);
echo "</pre>";
echo "<br/>";

$response = "";
while ((strpos($buffer, '410') !== false)) {
    $response = $connect->serverconnect("EAT /pizza/$id/\nTable => $table\n\n");
    echo "<pre>";
    print_r($response);
    echo "</pre>";
    echo "<br/>";

    $loc = trim($parser->get_header($response, "Location"));
    if ((strpos($response, '302') !== false)) {
        $loc = trim($parser->get_header($response,"Location"));
        $result = $connect->serverconnect("EAT $loc\nTable => $table\n\n");
        echo "EAT $loc\nTable => $table\n\n";
        echo "<pre>";
        print_r($result);
        echo "</pre>";
        echo "<br/>";
    }
}
