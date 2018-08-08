<?php

abstract class response_parser
{

    protected $data;

    abstract protected function getData();

    public function setData($data)
    {
        $this->data = $data;
    }
}

?>