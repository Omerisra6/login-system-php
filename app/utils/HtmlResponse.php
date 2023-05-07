<?php
namespace  app\utils;

class HtmlResponse
{
    private $filePath;
    private $attributes;

    public function __construct($filePath, $attributes = [])
    {
        $this->filePath = $filePath;
        $this->attributes = $attributes;
    }

    static function make( $filePath, $attributes = [] )
    {
        return new static( $filePath, $attributes );
    }

    public function send()
    {
        ob_start();
        extract($this->attributes);
        include $this->filePath;
        $content = ob_get_clean();
        
        header('Content-Type: text/html');
        echo $content;
        exit();
    }
}
