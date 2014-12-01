<?php
/**
 * Created by Erik Figueiredo.
 * Email: falecom@erikfigueiredo.com.br
 * Date: 26/11/14
 * Time: 16:50
 */

namespace WebDevBr\SimpleDb\Mysql\Instructions;

use WebDevBr\SimpleDb\InstructionsAbstract;

class Update extends InstructionsAbstract
{
    protected function setSql()
    {
        $this->sql = 'UPDATE '.$this->table . ' SET' . $this->values;
    }

    public function setValues(Array $values=[])
    {
        if (empty($values) or !is_array($values))
            throw new \InvalidArgumentException('Empty value, setValues() expected array whith values');

        $this->setBind($values);

        $keys = array_keys($values);
        foreach ($keys as $v)
            $sql[] = $v.'=:'.$v;

        $this->values = ' '.implode(', ', $sql);

        return $this;
    }
}