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

class RoleSimple implements RoleInterface
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var RoleSimple[]
     */
    protected static $roles = array();

    /**
     * @param string $id
     */
    protected function __construct($id)
    {
        $this->id = (string)$id;
    }

    /**
     * Creates or returns existing role object with specified $id
     *
     * @param string $id
     * @return RoleSimple
     */
    public static function factory($id)
    {
        $id = (string)$id;
        if (!isset(static::$roles[$id])) {
            static::$roles[$id] = new static($id);
        }
        return static::$roles[$id];
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->id;
    }
}
