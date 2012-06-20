<?php

namespace FSi\ACL;

class ResourceSimple implements ResourceInterface
{
    protected $id;

    protected static $resources = array();

    protected function __construct($id)
    {
        $this->id = (string)$id;
    }

    public static function factory($id)
    {
        $id = (string)$id;
        if (!isset(static::$resources[$id])) {
            static::$resources[$id] = new static($id);
        }
        return static::$resources[$id];
    }
}
