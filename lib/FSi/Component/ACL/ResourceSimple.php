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

class ResourceSimple implements ResourceInterface
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var ResourceSimple[]
     */
    protected static $resources = array();

    /**
     * @param string $id
     */
    protected function __construct($id)
    {
        $this->id = (string)$id;
    }

    /**
     * Creates or returns existing resource object with specified $id
     *
     * @param string $id
     * @return ResourceSimple
     */
    public static function factory($id)
    {
        $id = (string)$id;
        if (!isset(static::$resources[$id])) {
            static::$resources[$id] = new static($id);
        }
        return static::$resources[$id];
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->id;
    }
}
