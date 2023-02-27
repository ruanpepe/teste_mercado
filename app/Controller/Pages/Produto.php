<?php

namespace App\Controller\Pages;

use App\Http\Request;
use App\Utils\View;
use App\Model\Entity\Produto as ProdutoModel;
use App\Model\Entity\ProdutoTipo;

class Produto extends Page
{
    /**
     * Retorna as linhas de Produtos
     * @return string
     */
    public static function pegarLinhas()
    {
        $itens = '';

        $results = ProdutoModel::selectAll();
        while ($produto = $results->fetchObject(ProdutoModel::class)) {
            $itens .= View::render('pages/produto/item', [
                'id' => $produto->id,
                'nome' => $produto->nome,
                'preco' => $produto->preco,
            ]);
        }

        return $itens;
    }

    /**
     * Retorna as linhas de Produtos
     * @return string
     */
    public static function pegarLinhasComImpostos()
    {
        $itens = '';

        $results = ProdutoModel::selectAllWithImpostos();
        while ($produto = $results->fetchObject(ProdutoModel::class)) {
            $itens .= View::render('pages/produto/item_venda', [
                'id' => $produto->id,
                'nome' => $produto->nome,
                'preco' => $produto->preco ?? 0,
                'imposto' => $produto->imposto ?? 0,
            ]);
        }

        return $itens;
    }

    /**
     * Retorna a view da lista de produtos
     * @return string
     */
    public static function listar()
    {
        $content = View::render('pages/produto/list', [
            'itens' => self::pegarLinhas()
        ]);
        return parent::getPage('Produtos de produtos', $content);
    }

    /**
     * Cadastra um novo produto
     * @param Request $request
     * @return string
     */
    public static function cadastrar($request)
    {
        $postVars = $request->getPostVars();

        $novoProduto = new ProdutoModel();
        $novoProduto->nome = $postVars['nome'];
        $novoProduto->preco = $postVars['preco'];
        $result = $novoProduto->create();

        return self::listar();
    }

    /**
     * Retorna a view de edição de produto
     * @param Request $request
     * @return string
     */
    public static function editar($id)
    {
        $result = ProdutoModel::selectById($id);
        $produto = $result->fetchObject(ProdutoModel::class);
        $content = View::render('pages/produto/edit', [
            'id' => $produto->id,
            'nome' => $produto->nome,
            'preco' => $produto->preco,
            'linhasDeTipos' => Tipo::pegarLinhasParaProduto($id),
        ]);
        return parent::getPage('Produtos de produtos', $content);
    }

    /**
     * Vincula produto ao tipo
     * @param int $produtoId
     * @param int $tipoId
     * @return string
     */
    public static function vincularTipo($produtoId, $tipoId)
    {
        $produtoTipo = new ProdutoTipo();
        $produtoTipo->id_produto = $produtoId;
        $produtoTipo->id_tipo = $tipoId;
        $produtoTipo->create();

        return self::editar($produtoId);
    }

    /**
     * Desvincula produto ao tipo
     * @param int $produtoId
     * @param int $tipoId
     * @return string
     */
    public static function desvincularTipo($produtoId, $tipoId)
    {
        $produtoTipo = new ProdutoTipo();
        $produtoTipo->id_produto = $produtoId;
        $produtoTipo->id_tipo = $tipoId;
        $produtoTipo->delete();

        return self::editar($produtoId);
    }

    /**
     * Atualiza um produto
     * @param Request $request
     * @return string
     */
    public static function atualizar($request)
    {
        $postVars = $request->getPostVars();
        $produto = new ProdutoModel();
        $produto->id = $postVars['id'];
        $produto->nome = $postVars['nome'];
        $produto->preco = $postVars['preco'];
        $result = $produto->update();

        return self::listar();
    }

    /**
     * Deleta um produto
     * 
     * @param int $id
     * @return string
     */
    public static function deletar($id)
    {
        $produto = new ProdutoModel();
        $produto->id = $id;
        $result = $produto->delete();

        return self::listar();
    }
}
