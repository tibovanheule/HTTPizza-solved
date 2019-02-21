<?php

class Connect
{
    function serverconnect($query)
    {

        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        socket_connect($socket, "10.0.0.164", 31415);
        $wbuffer = $query;
        socket_write($socket, $wbuffer, strlen($wbuffer));
        $buffer = socket_read($socket, MAXLINE);
        if (strpos($buffer, '200') === false) {
            echo "Error: ";
            print_r($buffer);
            die();
        }
        socket_close($socket);
        return $buffer;
    }
    function bruteforce($query):bool
    {
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        socket_connect($socket, "10.0.0.164", 31415);
        $wbuffer = $query;
        socket_write($socket, $wbuffer, strlen($wbuffer));
        $buffer = socket_read($socket, MAXLINE);
        socket_close($socket);
        return strpos($buffer, '200') !== false;
    }

}