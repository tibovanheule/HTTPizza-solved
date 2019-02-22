<?php

class Connect
{
    function serverconnect($query)
    {

        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        socket_connect($socket, "10.0.0.167", 4000);
        $wbuffer = $query;
        socket_write($socket, $wbuffer, strlen($wbuffer));
        $buffer = socket_read($socket, MAXLINE);
        if ((strpos($buffer, '200') === false) and (strpos($buffer, '202') === false) and (strpos($buffer, '302') === false) and (strpos($buffer, '410') === false)) {
            echo "Error: ";
            print_r($buffer);
            die();
        }
        socket_close($socket);
        return $buffer;
    }

    function bruteforce($query)
    {
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        socket_connect($socket, "10.0.0.167", 4000);
        $wbuffer = $query;
        socket_write($socket, $wbuffer, strlen($wbuffer));
        $buffer = socket_read($socket, MAXLINE);
        socket_close($socket);
        return $buffer;
    }

}