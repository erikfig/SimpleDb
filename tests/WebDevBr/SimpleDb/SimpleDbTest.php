<?php
/**
 * Created by Erik Figueiredo.
 * Email: falecom@erikfigueiredo.com.br
 * Date: 26/11/14
 * Time: 15:43
 */

namespace WebDevBr\SimpleDb;

use PHPUnit_Extensions_Database_TestCase,
    WebDevBr\SimpleDb\SimpleDb,
    WebDevBr\SimpleDb\Mysql\Instructions\Insert,
    WebDevBr\SimpleDb\Mysql\Instructions\Update,
    WebDevBr\SimpleDb\Mysql\Instructions\Delete,
    WebDevBr\SimpleDb\Mysql\Instructions\Select,
    WebDevBr\SimpleDb\Mysql\Filters;

class SimpleDbTest extends PHPUnit_Extensions_Database_TestCase
{
    private $config = [
        'dsn'=>'mysql:host=localhost;dbname=curso_tdd',
        'username'=>'root',
        'password'=>'',
        'options'=>[]
    ];
    private $config_errado = [
        'dsn'=>'mysql:host=localhost;dbname=curso_stdd',
        'username'=>'root',
        'password'=>'',
        'options'=>[]
    ];

    public function testRetornaOPdo()
    {
        $simple_db = new SimpleDb($this->config);
        $this->assertInstanceOf('PDO', $simple_db->connect());
    }

    /**
     * @expectedException        Exception
     */
    public function testNaoConectou()
    {
        $simple_db = new SimpleDb($this->config_errado);

        $simple_db->connect();
    }

    public function getConnection()
    {
        $pdo = new \PDO($GLOBALS['BD_DSN'], $GLOBALS['BD_USUARIO'], $GLOBALS['BD_SENHA']);

        $conn = $this->createDefaultDBConnection($pdo, $GLOBALS['BD_NOMEBD']);

        return $conn;
    }

    public function getDataSet()
    {
        return $this->createXMLDataSet(
            'db_datas.xml'
        );
    }

    public function testComandosSql()
    {
        $simple_db = new SimpleDb($this->config);
        $filters = new Filters();
        $filters->where('id', '=', 3);

        $pdo = $simple_db->connect();

        //insert
        $instruction = new Insert();
        $instruction->setTable('pages')
            ->setValues(['title'=>'Home', 'content'=>'Example']);

        $sql = $simple_db->execute($instruction);

        $this->assertTrue($sql);

        //update
        $instruction = new Update();
        $instruction->setTable('pages')
            ->setValues(['title'=>'Página inicial', 'content'=>'Agora atualizado'])
            ->setFilters($filters);

        $sql = $simple_db->execute($instruction);

        $this->assertTrue($sql);

        //select
        $instruction = new Select();
        $instruction->setTable('pages')
            ->setValues()
            ->setFilters($filters);

        $sql = $simple_db->execute($instruction);

        $this->assertTrue($sql);

        $result = $simple_db->getPdoStatement()->fetch(\PDO::FETCH_ASSOC);
        $experamos = [
            'id'=>3,
            'title'=>'Página inicial',
            'content'=>'Agora atualizado'
        ];

        $this->assertEquals($experamos, $result);

        //delete
        $instruction = new Delete();
        $instruction->setTable('pages')
            ->setFilters($filters);

        $sql = $simple_db->execute($instruction);

        $this->assertTrue($sql);

    }
}