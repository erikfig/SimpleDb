<?php
/**
 * Created by Erik Figueiredo.
 * Email: falecom@erikfigueiredo.com.br
 * Date: 26/11/14
 * Time: 15:44
 */

namespace WebDevBr\SimpleDb\Mysql\Instructions\MySql;

use PHPUnit_Framework_TestCase,
    WebDevBr\SimpleDb\Mysql\Instructions\Select,
    WebDevBr\SimpleDb\Mysql\Filters;

class SelectTest extends PHPUnit_Framework_TestCase
{

    /**
     * @expectedException        InvalidArgumentException
     */
    public function testValorErradoNaTabelaDeveRetornarErro()
    {
        $instruction = new Select();
        $instruction->setTable([1,2]);
    }

    public function testCamposDeRetornoDoSelect()
    {
        $instruction = new Select();
        $instruction->setValues(['id', 'title', 'content']);
        $sql = $instruction->getValues();

        $experamos = " id, title, content ";
        $this->assertEquals($experamos, $sql);

        $instruction->setValues();
        $sql = $instruction->getValues();

        $experamos = " * ";
        $this->assertEquals($experamos, $sql);
    }

    public function testDadosParaOBindDoPdo()
    {
        $instruction = new Select();
        $filters = new Filters();
        $instruction->setFilters($filters)->where('title','=', 'Home')
            ->whereOperator('AND')
            ->where('content','=', '<h1>Conteudo</h1>');
        $bind = $instruction->getBind();

        $experamos = [':title'=>'Home', ':content'=>'<h1>Conteudo</h1>'];
        $this->assertEquals($experamos, $bind);
    }

    public function testRetornaObjetoFiltro()
    {
        $instruction = new Select();
        $filters = new Filters();

        $filters = $instruction->setFilters($filters);

        $this->assertInstanceOf('WebDevBr\SimpleDb\Mysql\Filters', $filters);
    }

    public function testSqlDeSelect()
    {
        $instruction = new Select();
        $filters = new Filters();

        $instruction->setTable('pages')
            ->setValues(['id', 'title', 'content'])
            ->setFilters($filters)->where('title','=', 'home')
                ->whereOperator('AND')
                ->where('content','=', 'conteudo');

        $sql = $instruction->getSql();

        $experamos = "SELECT id, title, content FROM pages WHERE title=:title AND content=:content;";
        $this->assertEquals($experamos, $sql);
    }
} 