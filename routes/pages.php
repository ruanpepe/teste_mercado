<?php

use \App\Http\Response;
use \App\Controller\Pages;

$router->get('/', [
    function () {
        return new Response(200, Pages\Home::getHome());
    }
]);

// Rotas de tipos
$router->get('/tipo/deletar/{id}', [
    function ($id) {
        return new Response(200, Pages\Tipo::deletar($id));
    }
]);
$router->get('/tipo/editar/{id}', [
    function ($id) {
        return new Response(200, Pages\Tipo::editar($id));
    }
]);
$router->post('/tipo/atualizar', [
    function ($request) {
        return new Response(200, Pages\Tipo::atualizar($request));
    }
]);
$router->get('/tipo', [
    function () {
        return new Response(200, Pages\Tipo::listar());
    }
]);
$router->get('/tipo/', [
    function () {
        return new Response(200, Pages\Tipo::listar());
    }
]);
$router->post('/tipo', [
    function ($request) {
        return new Response(200, Pages\Tipo::cadastrar($request));
    }
]);
$router->post('/tipo/', [
    function ($request) {
        return new Response(200, Pages\Tipo::cadastrar($request));
    }
]);

// Rotas de impostos
$router->get('/imposto/deletar/{id}', [
    function ($id) {
        return new Response(200, Pages\Imposto::deletar($id));
    }
]);
$router->post('/imposto', [
    function ($request) {
        return new Response(200, Pages\Imposto::cadastrar($request));
    }
]);
$router->post('/imposto/', [
    function ($request) {
        return new Response(200, Pages\Imposto::cadastrar($request));
    }
]);

// Rotas de Produtos
$router->get('/produto/{produtoId}/vinculartipo/{tipoId}', [
    function ($produtoId, $tipoId) {
        return new Response(200, Pages\Produto::vincularTipo($produtoId, $tipoId));
    }
]);
$router->get('/produto/{produtoId}/desvinculartipo/{tipoId}', [
    function ($produtoId, $tipoId) {
        return new Response(200, Pages\Produto::desvincularTipo($produtoId, $tipoId));
    }
]);
$router->get('/produto/deletar/{id}', [
    function ($id) {
        return new Response(200, Pages\Produto::deletar($id));
    }
]);
$router->get('/produto/editar/{id}', [
    function ($id) {
        return new Response(200, Pages\Produto::editar($id));
    }
]);
$router->post('/produto/atualizar', [
    function ($request) {
        return new Response(200, Pages\Produto::atualizar($request));
    }
]);
$router->get('/produto', [
    function () {
        return new Response(200, Pages\Produto::listar());
    }
]);
$router->get('/produto/', [
    function () {
        return new Response(200, Pages\Produto::listar());
    }
]);
$router->post('/produto', [
    function ($request) {
        return new Response(200, Pages\Produto::cadastrar($request));
    }
]);
$router->post('/tipo/', [
    function ($request) {
        return new Response(200, Pages\Produto::cadastrar($request));
    }
]);


$router->get('/venda', [
    function () {
        return new Response(200, Pages\Venda::nova());
    }
]);
$router->post('/venda', [
    function ($request) {
        return new Response(200, Pages\Venda::cadastrar($request));
    }
]);
