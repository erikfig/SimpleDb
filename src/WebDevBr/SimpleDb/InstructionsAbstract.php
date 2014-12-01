<?php
/**
 * Created by Erik Figueiredo.
 * Email: falecom@erikfigueiredo.com.br
 * Date: 26/11/14
 * Time: 16:51
 */

namespace WebDevBr\SimpleDb;

abstract class InstructionsAbstract
{
    protected $sql, $table, $values, $filters, $bind;

    abstract protected function setSql();

    public function setTable($table)
    {
        if (!is_string($table))
            throw new \InvalidArgumentException('Wrong value, setTable() expected string');
        $this->table = $table;
        return $this;
    }

    public function setFilters(Mysql\Filters $filters)
    {
        $this->filters = $filters;
        return  $this->filters;
    }

    abstract public function setValues(Array $values=[]);

    public function getValues()
    {
        return $this->values;
    }

    public function setBind($values)
    {
        if (empty($this->bind) or !is_array($this->bind))
            $this->bind = [];

        foreach ($values as $k=>&$v) {
            $this->bind[':'.$k] = $v;
        }
    }

    public function getBind()
    {
        if (!empty($this->filters))
            $this->setBind($this->filters->getBind());

        return $this->bind;
    }

    final public function getSql()
    {
        $this->setSql();

        $sql = $this->sql;

        if (!empty($this->filters))
            $sql .= $this->filters->getSql();
        return $sql.';';
    }

}