<?php

namespace App\Utils;

class HtmlResponse
{
    private $filePath;
    private $attributes;
    public $statusCode;

    public function __construct($filePath, $attributes = [], $statusCode = 200 )
    {
        $this->filePath = $filePath;
        $this->attributes = $attributes;
        $this->statusCode = $statusCode;
    }

    public static function make($filePath, $attributes = [])
    {
        return new static($filePath, $attributes);
    }

    public function send()
    {
        ob_start();
        extract($this->attributes);
        include $this->filePath;
        $content = ob_get_clean();

        header('Content-Type: text/html');
        echo $content;
    }
}
