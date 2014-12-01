<?php
/**
 * Created by Erik Figueiredo.
 * Email: falecom@erikfigueiredo.com.br
 * Date: 26/11/14
 * Time: 15:55
 */

namespace WebDevBr\SimpleDb\Mysql;


class Filters
{
    private $sql, $bind;

    public function where($field, $op, $value)
    {
        $this->sql['where'][] = $field.$op.':'.$field;
        $this->bind[$field] = $value;
        return $this;
    }

    public function whereOperator($op)
    {
        $this->sql['where'][] = $op;
        return $this;
    }

    public function limit($limit)
    {
        $this->sql['limit']=$limit;
        return $this;
    }

    public function orderBy($order_by)
    {
        $this->sql['order_by']=$order_by;
        return $this;
    }

    public function getConfig()
    {
        return $this->sql;
    }

    public function getSql()
    {
        $sql = '';

        if (!empty($this->sql['where']))
            $sql .= ' WHERE '.implode(' ', $this->sql['where']);
        if (!empty($this->sql['order_by']))
            $sql .= ' ORDER BY '.$this->sql['order_by'];
        if (!empty($this->sql['limit']))
            $sql .= ' LIMIT '.$this->sql['limit'];

        return $sql;
    }

    public function getBind()
    {
        return $this->bind;
    }
} 