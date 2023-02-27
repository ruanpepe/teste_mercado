<?php

namespace App\Model\Entity;

use PDOStatement;

class VendaProdutos
{
    public $id;
    public $id_venda;
    public $nome_produto;
    public $quantidade_produto;
    public $preco_base_produto;
    public $impostos_produto;
    public $preco_final_produto;

    /**
     * Insere um novo registro na tabela vendas
     * 
     * @return PDOStatement
     */
    public function create()
    {
        try {
            $sql = "INSERT INTO venda_produtos (id_venda, nome_produto, quantidade_produto, preco_base_produto, impostos_produto, preco_final_produto) VALUES (:id_venda, :nome_produto, :quantidade_produto, :preco_base_produto, :impostos_produto, :preco_final_produto)";
            $statement = DB_CONNECTION->prepare($sql);
            $statement->bindParam(':id_venda', $this->id_venda);
            $statement->bindParam(':nome_produto', $this->nome_produto);
            $statement->bindParam(':quantidade_produto', $this->quantidade_produto);
            $statement->bindParam(':preco_base_produto', $this->preco_base_produto);
            $statement->bindParam(':impostos_produto', $this->impostos_produto);
            $statement->bindParam(':preco_final_produto', $this->preco_final_produto);
            $statement->execute();
            return $statement;
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }
}
