<?php
/**
 * Created by Erik Figueiredo.
 * Email: falecom@erikfigueiredo.com.br
 * Date: 26/11/14
 * Time: 15:45
 */

namespace WebDevBr\SimpleDb\Mysql\Instructions\MySql;

use PHPUnit_Framework_TestCase,
    WebDevBr\SimpleDb\Mysql\Instructions\Insert;

class InsertTest extends PHPUnit_Framework_TestCase
{

    /**
     * @expectedException        InvalidArgumentException
     */
    public function testValorErradoNaTabelaDeveRetornarErro()
    {
        $instruction = new Insert();
        $instruction->setTable([1,2]);
    }

    public function testValoresAInserir()
    {
        $instruction = new Insert();
        $instruction->setValues(['title'=>'Home', 'content'=>'<h1>Conteudo</h1>']);
        $sql = $instruction->getValues();

        $experamos = ' (title, content) VALUES (:title, :content)';
        $this->assertEquals($experamos, $sql);
    }

    /**
     * @expectedException        InvalidArgumentException
     */
    public function testArrayValoresNaoEnviado()
    {
        $instruction = new Insert();
        $instruction->setValues();
    }

    public function testDadosParaOBindDoPdo()
    {
        $instruction = new Insert();
        $instruction->setValues(['title'=>'Home', 'content'=>'<h1>Conteudo</h1>']);
        $bind = $instruction->getBind();

        $experamos = [':title'=>'Home', ':content'=>'<h1>Conteudo</h1>'];
        $this->assertEquals($experamos, $bind);
    }

    /**
     * @expectedException        Exception
     */
    public function testRetornaObjetoFiltro()
    {
        $instruction = new Insert();
        $filters = new \WebDevBr\SimpleDb\Mysql\Filters();
        $instruction->setFilters($filters);
    }

    public function testSqlDeInsert()
    {
        $instruction = new Insert();
        $instruction->setTable('pages')
            ->setValues(['title'=>'Home']);
        $sql = $instruction->getSql();

        $experamos = "INSERT INTO pages (title) VALUES (:title);";
        $this->assertEquals($experamos, $sql);
    }
} 