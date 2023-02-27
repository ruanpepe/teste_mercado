<?php

namespace App\Controller\Pages;

use App\Controller\Pages\Produto as PagesProduto;
use App\Http\Request;
use App\Model\Entity\ProdutoTipo;
use App\Utils\View;
use App\Model\Entity\Produto as ProdutoModel;
use App\Model\Entity\Venda as VendaModel;
use App\Model\Entity\VendaProdutos as VendaProdutosModel;
use DateTime;

class Venda extends Page
{
    /**
     * Retorna a view da de nova venda
     * @return string
     */
    public static function nova()
    {
        $result = ProdutoModel::selectAllWithImpostos();
        $produto = $result->fetchObject(ProdutoModel::class);
        $content = View::render('pages/venda/nova', [
            'linhasDeProdutos' => Produto::pegarLinhasComImpostos(),
        ]);
        return parent::getPage('Nova venda', $content);
    }

    /**
     * Cadastra uma nova venda
     * @param Request $request
     * @return string
     */
    public static function cadastrar($request)
    {
        $postVars = $request->getPostVars();
        $postVars['valor_total_produto'] = [];
        $postVars['valor_total_imposto'] = [];
        $postVars['valor_total_produto_imposto'] = [];

        $produtosIds = [];
        foreach ($postVars['quantidade_produto'] as $key => $value) {
            if (!$value) {
                unset($postVars['nome_produto'][$key]);
                unset($postVars['valor_produto'][$key]);
                unset($postVars['imposto_produto'][$key]);
                unset($postVars['quantidade_produto'][$key]);
                continue;
            }
            $produtosIds[] = $key;
            $postVars['valor_total_produto'][$key] = $postVars['valor_produto'][$key] * $postVars['quantidade_produto'][$key];
            $postVars['valor_total_imposto'][$key] = ($postVars['imposto_produto'][$key] / 100 * ($postVars['valor_produto'][$key] * $postVars['quantidade_produto'][$key]));
            $postVars['valor_total_produto_imposto'][$key] = $postVars['valor_total_produto'][$key] + $postVars['valor_total_imposto'][$key];
        }

        $novaVenda = new VendaModel();
        $novaVenda->horario = (new DateTime())->format('Y-m-d H:i:s');
        $novaVenda->preco_base_produtos = array_sum($postVars['valor_total_produto']);
        $novaVenda->impostos_produtos = array_sum($postVars['valor_total_imposto']);
        $novaVenda->valor_total = array_sum($postVars['valor_total_produto_imposto']);
        $result = $novaVenda->create();
        $novaVenda->id = $result->fetchAll()['0']['id'];


        foreach ($produtosIds as $produtoId) {
            $vendaProduto = new VendaProdutosModel();
            $vendaProduto->id_venda = $novaVenda->id;
            $vendaProduto->nome_produto = $postVars['nome_produto'][$produtoId];
            $vendaProduto->quantidade_produto = $postVars['quantidade_produto'][$produtoId];
            $vendaProduto->preco_base_produto = $postVars['valor_produto'][$produtoId];
            $vendaProduto->impostos_produto = $postVars['imposto_produto'][$produtoId];
            $vendaProduto->preco_final_produto = ($vendaProduto->impostos_produto / 100 * $vendaProduto->preco_base_produto) + $vendaProduto->preco_base_produto;

            if (!$value) {
                unset($postVars['nome_produto'][$key]);
                unset($postVars['valor_produto'][$key]);
                unset($postVars['imposto_produto'][$key]);
                unset($postVars['quantidade_produto'][$key]);
                continue;
            }
            $produtosIds[] = $key;
            $postVars['valor_total_produto'][$key] = $postVars['valor_produto'][$key] * $postVars['quantidade_produto'][$key];
            $postVars['valor_total_imposto'][$key] = ($postVars['imposto_produto'][$key] / 100 * ($postVars['valor_produto'][$key] * $postVars['quantidade_produto'][$key]));
            $postVars['valor_total_produto_imposto'][$key] = $postVars['valor_total_produto'][$key] + $postVars['valor_total_imposto'][$key];
        }

        return self::nova();
    }
}
