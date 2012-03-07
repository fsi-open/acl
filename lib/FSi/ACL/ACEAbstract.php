<?php

namespace FSi\ACL;

abstract class ACEAbstract implements ACEInterface
{
    protected $_role;

    protected $_resource;

    protected $_permission;

    public function __construct(RoleInterface $role, ResourceInterface $resource, PermissionInterface $permission)
    {
        $this->_role = $role;
        $this->_resource = $resource;
        $this->_permission = $permission;
    }

    public function getRole()
    {
        return $this->_role;
    }

    public function getResource()
    {
        return $this->_resource;
    }

    public function getPermission()
    {
        return $this->_permission;
    }
}
