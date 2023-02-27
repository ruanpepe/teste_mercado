<?php

namespace App\Model\Entity;

use PDOStatement;

class Produto
{
    public $id;
    public $nome;
    public $preco;
    public $imposto;

    /**
     * Retorna todos os registros da tabela produtos
     * 
     * @return PDOStatement
     */
    public static function selectAll()
    {
        try {
            $sql = 'SELECT * FROM produtos';
            $statement =  DB_CONNECTION->prepare($sql);
            $statement->execute();
            return $statement;
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    /**
     * Retorna todos os registros da tabela produtos
     * 
     * @return PDOStatement
     */
    public static function selectAllWithImpostos()
    {
        try {
            $sql = "
                SELECT produtos.*, SUM(i.percentual) as imposto
                FROM produtos
                
                LEFT JOIN produto_tipo pt ON produtos.id = pt.id_produto
                LEFT JOIN tipos ON pt.id_tipo = tipos.id
                LEFT JOIN impostos i ON i.id_tipo = tipos.id
                
                GROUP BY produtos.id";
            $statement =  DB_CONNECTION->prepare($sql);
            $statement->execute();
            return $statement;
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    /**
     * Retorna um registro da tabela produtos pelo id
     * 
     * @param int $id
     * @return PDOStatement
     */
    public static function selectById($id)
    {
        try {
            $sql = 'SELECT * FROM produtos WHERE id = ' . $id;
            $statement =  DB_CONNECTION->prepare($sql);
            $statement->execute();
            return $statement;
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    /**
     * Insere um novo registro na tabela produtos
     * 
     * @return boolean
     */
    public function create()
    {
        try {
            $sql = "INSERT INTO produtos (nome, preco) VALUES (:nome, :preco)";
            $statement = DB_CONNECTION->prepare($sql);
            $statement->bindParam(':nome', $this->nome);
            $statement->bindParam(':preco', $this->preco);
            $statement->execute();
            return true;
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    /**
     * Atualiza um registro na tabela produtos
     */
    public function update()
    {
        try {
            $sql = "UPDATE produtos SET nome = :nome, preco = :preco WHERE id = :id";
            $statement =  DB_CONNECTION->prepare($sql);
            $statement->bindParam(':id', $this->id);
            $statement->bindParam(':nome', $this->nome);
            $statement->bindParam(':preco', $this->preco);
            $statement->execute();
            return true;
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    /**
     * Apaga um registro na tabela produtos
     */
    public function delete()
    {
        try {
            $sql = "DELETE FROM produtos WHERE id = :id";
            $statement =  DB_CONNECTION->prepare($sql);
            $statement->bindParam(':id', $this->id);
            $statement->execute();
            return true;
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }
}
