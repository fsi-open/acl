<?php

namespace FSi\ACL;

class PermissionSimple implements PermissionInterface
{
    protected $id;

    protected static $permissions = array();

    protected function __construct($id)
    {
        $this->id = (string)$id;
    }

    public static function factory($id)
    {
        $id = (string)$id;
        if (!isset(static::$permissions[$id])) {
            static::$permissions[$id] = new static($id);
        }
        return static::$permissions[$id];
    }
}
