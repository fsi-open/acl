<?php

/*
 * This file is part of the FSi Component package.
 *
 * (c) Lukasz Cybula <lukasz@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FSi\Component\ACL;

class PermissionSimple implements PermissionInterface
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var PermissionSimple[]
     */
    protected static $permissions = array();

    /**
     * @param string $id
     */
    protected function __construct($id)
    {
        $this->id = (string)$id;
    }

    /**
     * Creates or returns existing permission object with specified $id
     *
     * @param string $id
     * @return PermissionSimple
     */
    public static function factory($id)
    {
        $id = (string)$id;
        if (!isset(static::$permissions[$id])) {
            static::$permissions[$id] = new static($id);
        }
        return static::$permissions[$id];
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->id;
    }
}
