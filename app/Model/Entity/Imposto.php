<?php

namespace App\Model\Entity;

use PDOStatement;

class Imposto
{
    public $id;
    public $id_tipo;
    public $nome;
    public $percentual;

    /**
     * Retorna todos os registros da tabela imposto de um determinaado tipo
     * 
     * @return PDOStatement
     */
    public static function selectAll($tipoId)
    {
        try {
            $sql = 'SELECT * FROM impostos WHERE id_tipo = ' . $tipoId;
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
            $sql = 'SELECT * FROM impostos WHERE id = ' . $id;
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
            $sql = "INSERT INTO impostos (id_tipo,nome,percentual) VALUES (:id_tipo,:nome,:percentual)";
            $statement = DB_CONNECTION->prepare($sql);
            $statement->bindParam(':id_tipo', $this->id_tipo);
            $statement->bindParam(':nome', $this->nome);
            $statement->bindParam(':percentual', $this->percentual);
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
            $sql = "DELETE FROM impostos WHERE id = :id";
            $statement =  DB_CONNECTION->prepare($sql);
            $statement->bindParam(':id', $this->id);
            $statement->execute();
            return true;
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }
}
