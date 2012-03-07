<?php

namespace FSi\ACL;

class RoleSimple implements RoleInterface
{
    protected $id;

    protected static $roles = array();

    protected function __construct($id)
    {
        $this->id = (string)$id;
    }

    public static function factory($id)
    {
        $id = (string)$id;
        if (!isset(self::$roles[$id])) {
            self::$roles[$id] = new self($id);
        }
        return self::$roles[$id];
    }
}
