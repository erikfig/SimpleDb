<?php
/**
 * Created by Erik Figueiredo.
 * Email: falecom@erikfigueiredo.com.br
 * Date: 26/11/14
 * Time: 15:45
 */

namespace WebDevBr\SimpleDb\Mysql\Instructions\MySql;

use PHPUnit_Framework_TestCase,
    WebDevBr\SimpleDb\Mysql\Instructions\Delete,
    WebDevBr\SimpleDb\Mysql\Filters;

class DeleteTest extends PHPUnit_Framework_TestCase
{

    /**
     * @expectedException        InvalidArgumentException
     */
    public function testValorErradoNaTabelaDeveRetornarErro()
    {
        $instruction = new Delete();
        $instruction->setTable([1,2]);
    }

    /**
     * @expectedException        Exception
     */
    public function testValoresNaoSaoPermitidoEmDelete()
    {
        $instruction = new Delete();
        $instruction->setValues();
    }

    public function testDadosParaOBindDoPdo()
    {
        $instruction = new Delete();
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
        $instruction = new Delete();
        $filters = new Filters();

        $filters = $instruction->setFilters($filters);

        $this->assertInstanceOf('WebDevBr\SimpleDb\Mysql\Filters', $filters);
    }

    public function testSqlDeDelete()
    {
        $instruction = new Delete();
        $filters = new Filters();

        $instruction->setTable('pages')
            ->setFilters($filters)
                ->where('title','=', 'home')
                ->whereOperator('AND')
                ->where('content','=', 'conteudo');

        $sql = $instruction->getSql();

        $experamos = "DELETE FROM pages WHERE title=:title AND content=:content;";
        $this->assertEquals($experamos, $sql);
    }
} 