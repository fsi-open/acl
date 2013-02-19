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

class ACEDeny extends ACEAbstract
{
    /**
     * This ACE always revokes access by returning false
     *
     * @param array $params
     * @return bool
     */
    public function isAllowed(array $params = array())
    {
        return false;
    }
}
