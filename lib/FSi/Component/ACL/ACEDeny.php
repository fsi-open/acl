<?php

namespace FSi\Component\ACL;

class ACEDeny extends ACEAbstract
{
    public function isAllowed()
    {
        return false;
    }
}
