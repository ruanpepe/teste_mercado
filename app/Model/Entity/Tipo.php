<?php

namespace App\Model\Entity;

use PDOStatement;

class Tipo
{
    public $id;
    public $nome;
    public $imposto;

    /**
     * Retorna todos os registros da tabela tipos
     * 
     * @return PDOStatement
     */
    public static function selectAll()
    {
        try {
            $sql = 'SELECT * FROM tipos';
            $statement =  DB_CONNECTION->prepare($sql);
            $statement->execute();
            return $statement;
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    /**
     * Retorna todos os registros da tabela tipos com os impostos
     * 
     * @return PDOStatement
     */
    public static function selectAllWithImpostos()
    {
        try {
            $sql = 'SELECT t.*, sum(i.percentual) as imposto FROM tipos t LEFT JOIN impostos i ON t.id = i.id_tipo group by t.id';
            $statement =  DB_CONNECTION->prepare($sql);
            $statement->execute();
            return $statement;
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    /**
     * Retorna um registro da tabela tipos pelo id
     * 
     * @param int $id
     * @return PDOStatement
     */
    public static function selectById($id)
    {
        try {
            $sql = 'SELECT * FROM tipos WHERE id = ' . $id;
            $statement =  DB_CONNECTION->prepare($sql);
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
            $sql = "INSERT INTO tipos (nome) VALUES (:nome)";
            $statement = DB_CONNECTION->prepare($sql);
            $statement->bindParam(':nome', $this->nome);
            $statement->execute();
            return true;
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    /**
     * Atualiza um registro na tabela tipos
     */
    public function update()
    {
        try {
            $sql = "UPDATE tipos SET nome = :nome WHERE id = :id";
            $statement =  DB_CONNECTION->prepare($sql);
            $statement->bindParam(':id', $this->id);
            $statement->bindParam(':nome', $this->nome);
            $statement->execute();
            return true;
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    /**
     * Apaga um registro na tabela tipos
     */
    public function delete()
    {
        try {
            $sql = "DELETE FROM tipos WHERE id = :id";
            $statement =  DB_CONNECTION->prepare($sql);
            $statement->bindParam(':id', $this->id);
            $statement->execute();
            return true;
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }
}
