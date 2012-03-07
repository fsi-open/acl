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
        if (!isset(self::$resources[$id])) {
            self::$resources[$id] = new self($id);
        }
        return self::$resources[$id];
    }
}
