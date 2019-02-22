<?php
/**
 * Created by PhpStorm.
 * User: seven
 * Date: 2/21/2019
 * Time: 9:26 PM
 */

class parser
{

    function get_header($response, $get)
    {
        echo "<br/>";
        $strings = preg_split('/ /', $response, 3);
        $second = array_pop($strings);
        $beuty = preg_replace('/\n/', ' ', $response);
        $beuty = preg_replace('/ => /', ':', $beuty);
        $beuty = (explode(" ", $beuty));
        $i = 0;
        while (strpos($beuty[$i], $get) === false && $i< count($beuty)) {
            $i++;
        }
        return explode(':',$beuty[$i])[1];
    }
    function json($response){
        return substr($response,strpos($response, '{'));
    }
    function combination($array) {
        // initialize by adding the empty set
        $results = array(array( ));

        foreach ($array as $element)
            foreach ($results as $combination)
                array_push($results, array_merge(array($element), $combination));

        return $results;
    }
}