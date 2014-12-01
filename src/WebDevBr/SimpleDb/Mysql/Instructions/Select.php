<?php
/**
 * Created by Erik Figueiredo.
 * Email: falecom@erikfigueiredo.com.br
 * Date: 26/11/14
 * Time: 16:50
 */

namespace WebDevBr\SimpleDb\Mysql\Instructions;

use WebDevBr\SimpleDb\InstructionsAbstract;

class Select extends InstructionsAbstract
{
    protected function setSql()
    {
        $this->sql = 'SELECT'.$this->values.'FROM '.$this->table;
    }

    public function setValues(Array $values=[])
    {
        $sql = '*';
        if (!empty($values))
            $sql = implode(', ', $values);

        $this->values = ' '.$sql.' ';
        return $this;
    }

} 