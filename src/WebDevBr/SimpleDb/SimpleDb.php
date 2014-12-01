<?php
/**
 * Created by Erik Figueiredo.
 * Email: falecom@erikfigueiredo.com.br
 * Date: 26/11/14
 * Time: 19:27
 */

namespace WebDevBr\SimpleDb;


class SimpleDb
{
    private $config, $pdo_statement;

    public function __construct(Array $config)
    {
        $this->config = $config;
    }

    public function connect()
    {
        try {
            $this->pdo = new \PDO(
                $this->config['dsn'],
                $this->config['username'],
                $this->config['password'],
                $this->config['options']
            );
        } catch(\PDOException $e){
            throw new \Exception('Erro ao conectar. Código: '.$e->getCode().'! Mensagem: '.$e->getMessage());
        }
        return $this->pdo;
    }

    public function execute(InstructionsAbstract $instruction)
    {
        $sth = $this->pdo->prepare($instruction->getSql());

        foreach ($instruction->getBind() as $k => $v) {
            $sth->bindValue($k, $v);
        }

        $this->pdo_statement = $sth;

        return $sth->execute();
    }

    public function getPdoStatement()
    {
        return $this->pdo_statement;
    }
} 