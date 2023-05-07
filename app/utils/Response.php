<?php

namespace App\Utils;

class Response
{
    private $statusCode;
    private $data;
    private $redirect;

    public function __construct( $statusCode, $data = '', $redirect = false )
    {
        $this->statusCode = $statusCode;
        $this->data = $data;
        $this->redirect = $redirect;
    }

    static function make( $statusCode, $data = '', $redirect = false )
    {
        return new static( $statusCode, $data, $redirect );
    }

    public function send()
    {
        if ( $this->redirect ) 
        {
            header( 'Location: ' . $this->data, true, $this->statusCode );
            exit();
        }

        http_response_code( $this->statusCode );
        header( 'Content-Type: application/json' );
        echo json_encode( $this->data );
        exit();
    }
}