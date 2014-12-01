<?php
/**
 * Created by Erik Figueiredo.
 * Email: falecom@erikfigueiredo.com.br
 * Date: 26/11/14
 * Time: 15:43
 */

namespace WebDevBr\SimpleDb\Mysql;

use PHPUnit_Framework_TestCase,
    WebDevBr\SimpleDb\Mysql\Filters;

class FiltersTest extends PHPUnit_Framework_TestCase
{

    public function testWhere()
    {
        $filters = new Filters();
        $filters->where('id','=',1);
        $experamos = [
            'where'=>[
                'id=:id'
            ]
        ];
        $this->assertEquals($experamos, $filters->getConfig());
    }

    public function testOperadorWhere()
    {
        $filters = new Filters();
        $filters->whereOperator('OR');
        $experamos = [
            'where'=>[
                'OR'
            ]
        ];
        $this->assertEquals($experamos, $filters->getConfig());
    }

    public function testLimit()
    {
        $filters = new Filters();
        $filters->limit(10);
        $experamos = [
            'limit'=>10
        ];
        $this->assertEquals($experamos, $filters->getConfig());
    }

    public function testOrderBy()
    {
        $filters = new Filters();
        $filters->orderBy('id DESC');
        $experamos = [
            'order_by'=>'id DESC'
        ];
        $this->assertEquals($experamos, $filters->getConfig());
    }

    public function testFiltroSql()
    {
        $filters = new Filters();
        $filters->where('id', '>' ,2)
            ->whereOperator('AND')
            ->where('count', '<=' ,20)
            ->limit(20)
            ->orderBy('modified DESC');
        $experamos = ' WHERE id>:id AND count<=:count ORDER BY modified DESC LIMIT 20';
        $this->assertEquals($experamos, $filters->getSql());
    }

    public function testValoresParaBind()
    {
        $filters = new Filters();
        $filters->where('id', '>' ,2)
            ->whereOperator('AND')
            ->where('count', '<=' ,20);

        $experamos = [
            'id'=>2,
            'count'=>20
        ];
        $this->assertEquals($experamos, $filters->getBind());
    }
} 