<?php

namespace App\Model\Entity;

use PDOStatement;

class ProdutoTipo
{
    public $id;
    public $id_produto;
    public $id_tipo;

    /**
     * Retorna todos os tipos vinculados ao produto
     * 
     * @param int $idProduto
     * @return PDOStatement
     */
    public static function selectTiposFromProduto($idProduto)
    {
        try {
            $sql = 'SELECT * FROM produto_tipo WHERE id_produto = :id_produto';
            $statement =  DB_CONNECTION->prepare($sql);
            $statement->bindParam(':id_produto', $idProduto);
            $statement->execute();
            return $statement;
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    /**
     * Insere um novo registro na tabela tipos
     * 
     * @return boolean
     */
    public function create()
    {
        try {
            $sql = "INSERT INTO produto_tipo (id_produto, id_tipo) VALUES (:id_produto, :id_tipo)";
            $statement = DB_CONNECTION->prepare($sql);
            $statement->bindParam(':id_produto', $this->id_produto);
            $statement->bindParam(':id_tipo', $this->id_tipo);
            $statement->execute();
            return true;
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    /**
     * Apaga um registro na tabela produto_tipo
     */
    public function delete()
    {
        try {
            $sql = "DELETE FROM produto_tipo WHERE id_produto = :id_produto AND id_tipo = :id_tipo";
            $statement =  DB_CONNECTION->prepare($sql);
            $statement->bindParam(':id_produto', $this->id_produto);
            $statement->bindParam(':id_tipo', $this->id_tipo);
            $statement->execute();
            return true;
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }
}
