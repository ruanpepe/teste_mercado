<?php

namespace App\Model\Entity;

use PDOStatement;

class Venda
{
    public $id;
    public $horario;
    public $preco_base_produtos;
    public $impostos_produtos;
    public $valor_total;

    /**
     * Insere um novo registro na tabela vendas
     * 
     * @return PDOStatement
     */
    public function create()
    {
        try {
            $sql = "INSERT INTO vendas (horario, preco_base_produtos, impostos_produtos, valor_total) VALUES (:horario, :preco_base_produtos, :impostos_produtos, :valor_total) RETURNING id";
            $statement = DB_CONNECTION->prepare($sql);
            $statement->bindParam(':horario', $this->horario);
            $statement->bindParam(':preco_base_produtos', $this->preco_base_produtos);
            $statement->bindParam(':valor_total', $this->valor_total);
            $statement->bindParam(':impostos_produtos', $this->impostos_produtos);
            $statement->execute();
            return $statement;
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }
}
