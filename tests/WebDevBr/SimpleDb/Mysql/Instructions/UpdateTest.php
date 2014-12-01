<?php
/**
 * Created by Erik Figueiredo.
 * Email: falecom@erikfigueiredo.com.br
 * Date: 26/11/14
 * Time: 15:45
 */

namespace WebDevBr\SimpleDb\Mysql\Instructions\MySql;

use PHPUnit_Framework_TestCase,
    WebDevBr\SimpleDb\Mysql\Instructions\Update,
    WebDevBr\SimpleDb\Mysql\Filters;

class UpdateTest extends PHPUnit_Framework_TestCase
{

    /**
     * @expectedException        InvalidArgumentException
     */
    public function testValorErradoNaTabelaDeveRetornarErro()
    {
        $instruction = new Update();
        $instruction->setTable([1,2]);
    }

    public function testValoresAAtualizar()
    {
        $instruction = new Update();
        $instruction->setValues(['title'=>'Home', 'content'=>'<h1>Conteudo</h1>']);
        $sql = $instruction->getValues();

        $experamos = ' title=:title, content=:content';
        $this->assertEquals($experamos, $sql);
    }

    /**
     * @expectedException        InvalidArgumentException
     */
    public function testArrayValoresNaoEnviado()
    {
        $instruction = new Update();
        $instruction->setValues();
    }

    public function testDadosParaOBindDoPdo()
    {
        $instruction = new Update();
        $filters = new Filters();

        $instruction->setValues(['title'=>'Home', 'content'=>'<h1>Conteudo</h1>'])
            ->setFilters($filters)->where('id','=', 2);
        $bind = $instruction->getBind();

        $experamos = [':title'=>'Home', ':content'=>'<h1>Conteudo</h1>', ':id'=>2];
        $this->assertEquals($experamos, $bind);
    }

    public function testRetornaObjetoFiltro()
    {
        $instruction = new Update();
        $filters = new Filters();

        $filters = $instruction->setFilters($filters);

        $this->assertInstanceOf('WebDevBr\SimpleDb\Mysql\Filters', $filters);
    }

    public function testSqlDeUpdate()
    {
        $instruction = new Update();
        $filters = new Filters();

        $instruction->setTable('pages')
            ->setValues(['title'=>'Home'])
            ->setFilters($filters)
                ->where('id', '=', 2);
        $sql = $instruction->getSql();

        $experamos = "UPDATE pages SET title=:title WHERE id=:id;";
        $this->assertEquals($experamos, $sql);
    }
} 