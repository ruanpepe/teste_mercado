<?php

namespace App\Controller\Pages;

use App\Http\Request;
use App\Model\Entity\ProdutoTipo;
use App\Utils\View;
use App\Model\Entity\Tipo as TipoModel;

class Tipo extends Page
{
    /**
     * Retorna as linhas de tipos
     * @return string
     */
    public static function pegarLinhas()
    {
        $itens = '';

        $results = TipoModel::selectAll();
        while ($tipo = $results->fetchObject(TipoModel::class)) {
            $itens .= View::render('pages/tipo/item', [
                'id' => $tipo->id,
                'nome' => $tipo->nome,
            ]);
        }

        return $itens;
    }

    /**
     * Retorna as linhas de tipos
     * @param int $id_produto
     * @return string
     */
    public static function pegarLinhasParaProduto($id_produto)
    {
        $itens = '';

        $tiposVinculados = [];
        foreach ((ProdutoTipo::selectTiposFromProduto($id_produto))->fetchAll() as $type) {
            array_push($tiposVinculados, $type['id_tipo']);
        }

        $results = TipoModel::selectAllWithImpostos($tiposVinculados);
        while ($tipo = $results->fetchObject(TipoModel::class)) {
            $itens .= View::render('pages/produto/item_tipo', [
                'produtoId' => $id_produto,
                'tipoId' => $tipo->id,
                'nome' => $tipo->nome,
                'imposto' => $tipo->imposto ?? '0',
                'vinculado' => in_array($tipo->id, $tiposVinculados) ? 'checked' : '',
            ]);
        }

        return $itens;
    }

    /**
     * Retorna a view da lista de tipos
     * @return string
     */
    public static function listar()
    {
        $content = View::render('pages/tipo/list', [
            'itens' => self::pegarLinhas()
        ]);
        return parent::getPage('Tipos de produtos', $content);
    }

    /**
     * Cadastra um novo tipo
     * @param Request $request
     * @return string
     */
    public static function cadastrar($request)
    {
        $postVars = $request->getPostVars();

        $novoTipo = new TipoModel();
        $novoTipo->nome = $postVars['nome'];
        $result = $novoTipo->create();

        return self::listar();
    }

    /**
     * Retorna a view de edição de tipo
     * @param Request $request
     * @return string
     */
    public static function editar($id)
    {
        $result = TipoModel::selectById($id);
        $tipo = $result->fetchObject(TipoModel::class);
        $content = View::render('pages/tipo/edit', [
            'id' => $tipo->id,
            'nome' => $tipo->nome,
            'linhasDeImpostos' => Imposto::pegarLinhas($tipo->id),
        ]);
        return parent::getPage('Tipos de produtos', $content);
    }

    /**
     * Atualiza um tipo
     * @param Request $request
     * @return string
     */
    public static function atualizar($request)
    {
        $postVars = $request->getPostVars();
        $tipo = new TipoModel();
        $tipo->id = $postVars['id'];
        $tipo->nome = $postVars['nome'];
        $result = $tipo->update();

        return self::listar();
    }

    /**
     * Deleta um tipo
     * 
     * @param int $id
     * @return string
     */
    public static function deletar($id)
    {
        $tipo = new TipoModel();
        $tipo->id = $id;
        $result = $tipo->delete();

        return self::listar();
    }
}
