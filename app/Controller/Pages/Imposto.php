<?php

namespace App\Controller\Pages;

use App\Http\Request;
use App\Utils\View;
use App\Model\Entity\Imposto as ImpostoModel;

class Imposto extends Page
{
    /**
     * Retorna as linhas de tipos
     * @param int $id_tipo
     * @return string
     */
    public static function pegarLinhas($id_tipo)
    {
        $itens = '';

        $results = ImpostoModel::selectAll($id_tipo);
        while ($imposto = $results->fetchObject(ImpostoModel::class)) {
            $itens .= View::render('pages/tipo/imposto/item', [
                'id' => $imposto->id,
                'nome' => $imposto->nome,
                'percentual' => $imposto->percentual,
            ]);
        }

        return $itens;
    }

    /**
     * Cadastra um novo imposto
     * @param Request $request
     * @return string
     */
    public static function cadastrar($request)
    {
        $postVars = $request->getPostVars();

        $novoImposto = new ImpostoModel();
        $novoImposto->id_tipo = $postVars['tipo_id'];
        $novoImposto->nome = $postVars['imposto_nome'];
        $novoImposto->percentual = $postVars['imposto_percentual'];

        $result = $novoImposto->create();

        return Tipo::editar($novoImposto->id_tipo);
    }

    /**
     * Deleta um imposto
     * 
     * @param int $id
     * @return string
     */
    public static function deletar($id)
    {
        $imposto = new ImpostoModel();
        $result = ImpostoModel::selectById($id);
        $imposto = $result->fetchObject(ImpostoModel::class);
        $result = $imposto->delete();

        return Tipo::editar($imposto->id_tipo);
    }
}
