<?php

namespace App\Http;

class Response
{
    private $httpCode = 200;
    private $headers = [];
    private $contentType = 'text/html';
    private $content;

    /**
     * Construtor da classe
     * 
     * @param integer $httpCode
     * @param mixed $content
     * @param string $contentType
     */
    public function __construct($httpCode, $content, $contentType = 'text/html')
    {
        $this->httpCode = $httpCode;
        $this->content = $content;
        $this->setContentType($contentType);
    }

    /**
     * Atera o content type do response
     * 
     * @param string $contentType
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
        $this->addHeader('Content-Type', $contentType);
    }

    /**
     * Adiciona registro no cabeçalho do response
     * 
     * @param string $key
     * @param string $value
     */
    public function addHeader($key, $value)
    {
        $this->headers[$key] = $value;
    }

    /**
     * Envia os headers para o navegador
     */
    private function sendHeaders()
    {
        http_response_code($this->httpCode);
        foreach ($this->headers as $key => $value) {
            header($key . ': ' . $value);
        }
    }

    /**
     * Envia response ao usuário
     * 
     * @return void
     */
    public function sendResponse()
    {
        $this->sendHeaders();

        if ($this->contentType == 'text/html') {
            echo $this->content;
            return;
        }
    }
}
