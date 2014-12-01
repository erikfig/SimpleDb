<?php
/**
 * Created by Erik Figueiredo.
 * Email: falecom@erikfigueiredo.com.br
 * Date: 26/11/14
 * Time: 16:50
 */

namespace WebDevBr\SimpleDb\Mysql\Instructions;

use WebDevBr\SimpleDb\InstructionsAbstract,
    WebDevBr\SimpleDb\Mysql\Filters;

class Insert extends InstructionsAbstract
{
    protected function setSql()
    {
        $this->sql = 'INSERT INTO '.$this->table . $this->values;
    }

    public function setValues(Array $values=[])
    {
        if (empty($values) or !is_array($values))
            throw new \InvalidArgumentException('Empty value, setValues() expected array whith values');

        $this->setBind($values);

        $keys = array_keys($values);

        $columns = implode(', ', $keys);
        $values = implode(', :', $keys);

        $this->values = ' ('.$columns.') VALUES (:'.$values.')';

        return $this;
    }

    public function setFilters(Filters $filters)
    {
        throw new \Exception('Not allowed for Insert query');
    }
} 