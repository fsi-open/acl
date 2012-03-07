<?php

namespace FSi\ACL;

class ACEDeny extends ACEAbstract
{
    public function isAllowed()
    {
        return false;
    }
}
