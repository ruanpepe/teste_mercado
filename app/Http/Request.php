<?php

namespace App\Http;

class Request
{

    private $httpMethod;
    private $uri;
    private $queryParams = [];
    private $postVars = [];
    private $headers = [];

    /**
     * Construtor da classe
     */
    public function __construct()
    {
        $this->queryParams = $_GET ?? [];
        $this->postVars = $_POST ?? [];
        $this->headers = getallheaders();

        $this->httpMethod = $_SERVER['REQUEST_METHOD'] ?? '';
        $this->uri = $_SERVER['REQUEST_URI'] ?? '';
    }

    /**
     * Retorna o método HTTP da requisição
     * 
     * @return string
     */
    public function getHttpMethod()
    {
        return $this->httpMethod;
    }

    /**
     * Retorna URI da requisição
     * 
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Retorna parametros da URL da requisição
     * 
     * @return array
     */
    public function getQueryParams()
    {
        return $this->queryParams;
    }

    /**
     * Retorna as variáveis do POST da requisição
     * 
     * @return array
     */
    public function getPostVars()
    {
        return $this->postVars;
    }

    /**
     * Retorna os readers da requisição
     * 
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }
}
