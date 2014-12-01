<?php
/**
 * Created by Erik Figueiredo.
 * Email: falecom@erikfigueiredo.com.br
 * Date: 26/11/14
 * Time: 16:50
 */

namespace WebDevBr\SimpleDb\Mysql\Instructions;

use WebDevBr\SimpleDb\InstructionsAbstract;

class Delete extends InstructionsAbstract
{
    protected function setSql()
    {
        $this->sql = "DELETE FROM ".$this->table;
    }

    public function setValues(Array $values=[])
    {
        throw new \Exception('Not allowed for Delete query');
    }
} 