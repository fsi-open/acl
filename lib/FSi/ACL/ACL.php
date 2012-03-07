<?php

namespace FSi\ACL;

use FSi\DoctrineExtensions\Securable\Mapping\Annotation\Resource;

class ACL
{
    protected $resources = array();

    protected $roles = array();

    protected $permissions = array();

    protected $rolesParents = array();

    protected $resourcesParents = array();

    protected $ACEs = array();

    public function addPermission(PermissionInterface $permission)
    {
        if (in_array($permission, $this->permissions, true))
            throw new ACLException('Specified permission is already registered.');
        $permissionId = spl_object_hash($permission);
        $this->permissions[$permissionId] = $permission;
        return $this;
    }

    public function addRole(RoleInterface $role, array $parentRoles = array())
    {
        if (in_array($role, $this->roles, true))
            throw new ACLException('Specified role is already registered.');
        $roleId = spl_object_hash($role);
        $this->roles[$roleId] = $role;
        foreach ($parentRoles as $parentRole)
            $this->addParentRole($role, $parentRole);
        return $this;
    }

    protected function addParentRole(RoleInterface $role, RoleInterface $parentRole)
    {
        $roleId = spl_object_hash($role);
        $this->checkRoleRegistered($parentRole);
        $parentRoleId = spl_object_hash($parentRole);
        $this->rolesParents[$roleId][$parentRoleId] = $parentRole;
    }

    public function addResource(ResourceInterface $resource, array $parentResources = array())
    {
        if (in_array($resource, $this->resources, true))
            throw new ACLException('Specified resource is already registered.');
        $resourceId = spl_object_hash($resource);
        $this->resources[$resourceId] = $resource;
        foreach ($parentResources as $parentResource)
            $this->addParentResource($resource, $parentResource);
        return $this;
    }

    protected function addParentResource(ResourceInterface $resource, ResourceInterface $parentResource)
    {
        $resourceId = spl_object_hash($resource);
        $this->checkResourceRegistered($parentResource);
        $parentResourceId = spl_object_hash($parentResource);
        $this->resourcesParents[$resourceId][$parentResourceId] = $parentResource;
        return $this;
    }

    public function addACE(ACEInterface $ace)
    {
        $role = $ace->getRole();
        $resource = $ace->getResource();
        $permission = $ace->getPermission();
        $this->checkRoleRegistered($role);
        $this->checkResourceRegistered($resource);
        $this->checkPermissionRegistered($permission);
        if (in_array($ace, $this->ACEs, true))
            throw new ACLException('Specified ACE is already registered');
        $roleId = spl_object_hash($role);
        $resourceId = spl_object_hash($resource);
        $permissionId = spl_object_hash($permission);
        if (!isset($this->ACEs[$roleId]))
            $this->ACEs[$roleId] = array();
        if (!isset($this->ACEs[$roleId][$resourceId]))
            $this->ACEs[$roleId][$resourceId] = array();
        if (!isset($this->ACEs[$roleId][$resourceId][$permissionId]))
            $this->ACEs[$roleId][$resourceId][$permissionId] = array();
        $aceId = spl_object_hash($ace);
        $this->ACEs[$roleId][$resourceId][$permissionId][$aceId] = $ace;
        return $this;
    }

    public function isAllowed(RoleInterface $role, ResourceInterface $resource, PermissionInterface $permission)
    {
        $roleId = spl_object_hash($role);
        $resourceId = spl_object_hash($resource);
        $permissionId = spl_object_hash($permission);
        $allowed = $this->searchACEs($roleId, $resourceId, $permissionId);
        if (!isset($allowed))
            $allowed = $this->searchParentResourceACEs($roleId, $resourceId, $permissionId);
        if (!isset($allowed))
            $allowed = $this->searchParentRoleACEs($roleId, $resourceId, $permissionId);
        if (isset($allowed))
            return $allowed;
        return false;
    }

    protected function searchParentRoleACEs($roleId, $resourceId, $permissionId)
    {
        $allowedAny = null;
        if (isset($this->rolesParents[$roleId])) {
            foreach ($this->rolesParents[$roleId] as $parentRoleId => $parentRole) {
                $allowed = $this->searchACEs($parentRoleId, $resourceId, $permissionId);
                if (!isset($allowed))
                    $allowed = $this->searchParentResourceACEs($parentRoleId, $resourceId, $permissionId);
                if (!isset($allowed))
                    $allowed = $this->searchParentRoleACEs($parentRoleId, $resourceId, $permissionId);
                if (isset($allowed)) {
                    if (!$allowed)
                        return $allowed;
                    else
                        $allowedAny = true;
                }
            }
        }
        return $allowedAny;
    }

    protected function searchParentResourceACEs($roleId, $resourceId, $permissionId)
    {
        $allowedAny = null;
        if (isset($this->resourcesParents[$resourceId])) {
            foreach ($this->resourcesParents[$resourceId] as $parentResourceId => $parentResource) {
                $allowed = $this->searchACEs($roleId, $parentResourceId, $permissionId);
                if (!isset($allowed))
                    $allowed = $this->searchParentResourceACEs($roleId, $parentResourceId, $permissionId);
                if (isset($allowed)) {
                    if (!$allowed)
                        return $allowed;
                    else
                        $allowedAny = true;
                }
            }
        }
        return $allowedAny;
    }

    protected function searchACEs($roleId, $resourceId, $permissionId)
    {
/*        echo '-----'."\n";
        var_dump($this->roles[$roleId]);
        var_dump($this->resources[$resourceId]);
        var_dump($this->permissions[$permissionId]);*/
        if (!isset($this->ACEs[$roleId][$resourceId][$permissionId]))
            return null;
        else {
            foreach ($this->ACEs[$roleId][$resourceId][$permissionId] as $ace)
                if (!$ace->isAllowed())
                    return false;
            return true;
        }
    }

    protected function checkRoleRegistered(RoleInterface $role)
    {
        if (!in_array($role, $this->roles, true))
            throw new ACLException('Detected unregistered role throught relationship.');
    }

    protected function checkResourceRegistered(ResourceInterface $resource)
    {
        if (!in_array($resource, $this->resources, true))
            throw new ACLException('Detected unregistered resource throught relationship.');
    }

    protected function checkPermissionRegistered(PermissionInterface $permission)
    {
        if (!in_array($permission, $this->permissions, true))
            throw new ACLException('Detected unregistered permission throught relationship.');
    }
}
