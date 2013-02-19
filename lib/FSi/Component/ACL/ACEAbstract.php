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

abstract class ACEAbstract implements ACEInterface
{
    /**
     * @var RoleInterface
     */
    protected $_role;

    /**
     * @var ResourceInterface
     */
    protected $_resource;

    /**
     * @var PermissionInterface[]
     */
    protected $_permissions = array();

    /**
     * @var array
     */
    protected $_options;

    /**
     * Construct new ACE object with specified role, resource and permissions
     *
     * @param RoleInterface $role
     * @param ResourceInterface $resource
     * @param PermissionInterface|PermissionInterface[] $permissions
     */
    public function __construct(RoleInterface $role = null, ResourceInterface $resource = null, $permissions = null)
    {
        if (isset($role))
            $this->setRole($role);
        if (isset($resource))
            $this->setResource($resource);
        if (isset($permissions) && !empty($permissions))
            $this->setPermissions($permissions);
    }

    /**
     * {@interitDoc}
     */
    public function setRole(RoleInterface $role)
    {
        $this->_role = $role;
        return $this;
    }

    /**
     * {@interitDoc}
     */
    public function setResource(ResourceInterface $resource)
    {
        $this->_resource = $resource;
        return $this;
    }

    /**
     * {@interitDoc}
     */
    public function setPermissions($permissions)
    {
        if (!is_array($permissions))
            $permissions = array($permissions);
        foreach ($permissions as $permission) {
            if ($permission instanceof PermissionInterface)
                $this->_permissions[] = $permission;
            else
                throw new ACLException('Specified permission object does not implement PermissionInterface');
        }
        return $this;
    }

    /**
     * {@interitDoc}
     */
    public function setOptions(array $options = array())
    {
        $this->_options = $options;
    }

    /**
     * {@interitDoc}
     */
    public function getRole()
    {
        return $this->_role;
    }

    /**
     * {@interitDoc}
     */
    public function getResource()
    {
        return $this->_resource;
    }

    /**
     * {@interitDoc}
     */
    public function getPermissions()
    {
        return $this->_permissions;
    }

    /**
     * {@interitDoc}
     */
    public function getOptions()
    {
        return $this->_options;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return get_class($this);
    }
}
