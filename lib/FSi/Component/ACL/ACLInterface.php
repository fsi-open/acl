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

interface ACLInterface
{
    /**
     * Add new permission object to this ACL system.
     *
     * @param PermissionInterface $permission
     * @return ACLInterface
     */
    public function addPermission(PermissionInterface $permission);

    /**
     * Remove specified permission object from this ACL system.
     *
     * @param PermissionInterface $permission
     * @return ACLInterface
     */
    public function removePermission(PermissionInterface $permission);

    /**
     * Check if specified permission object is registered in this ACL system.
     *
     * @param PermissionInterface $permission
     * @return bool
     */
    public function hasPermission(PermissionInterface $permission);

    /**
     * Add new role object to this ACL system.
     *
     * @param RoleInterface $role
     * @param RoleInterface[] $parentRoles
     * @return ACLInterface
     */
    public function addRole(RoleInterface $role, array $parentRoles = array());

    /**
     * Remove specified role object from this ACL system.
     *
     * @param RoleInterface $role
     * @return ACLInterface
     */
    public function removeRole(RoleInterface $role);

    /**
     * Check if specified role object is registered in this ACL system.
     *
     * @param RoleInterface $role
     * @return bool
     */
    public function hasRole(RoleInterface $role);

    /**
     * Register specifed role as a child of specified parent role. Both roles must be registered in this ACL before calling this
     * method.
     *
     * @param RoleInterface $role
     * @param RoleInterface $parentRole
     * @return ACLInterface
     */
    public function addRoleParent(RoleInterface $role, RoleInterface $parentRole);

    /**
     * Remove specifed role from children's list of specified parent role.
     *
     * @param RoleInterface $role
     * @param RoleInterface $parentRole
     * @return ACLInterface
     */
    public function removeRoleParent(RoleInterface $role, RoleInterface $parentRole);

    /**
     * Remove specified role form children's list of all its current parent roles.
     *
     * @param RoleInterface $role
     * @param RoleInterface $parentRole
     * @return ACLInterface
     */
    public function removeRoleParents(RoleInterface $role);

    /**
     * Check if specified role is child of specified parent role.
     *
     * @param RoleInterface $role
     * @param RoleInterface $parentRole
     * @return bool
     */
    public function isRoleParent(RoleInterface $role, RoleInterface $parentRole);

    /**
     * Return array of all parent roles of specified role.
     *
     * @param RoleInterface $role
     * @return RoleInterface[]
     */
    public function getRoleParents(RoleInterface $role);

    /**
     * Return array of all children roles of specified role.
     *
     * @param RoleInterface $parentRole
     * @return RoleInterface[]
     */
    public function getRoleChildren(RoleInterface $parentRole);

    /**
     * Return array of all registered role objects which are instances of specified class.
     *
     * @param string $className
     * @return RoleInterface[]
     */
    public function getRolesByClass($className);

    /**
     * Add new resource object to this ACL system.
     *
     * @param ResourceInterface $resource
     * @param ResourceInterface[] $parentResources
     * @return ACLInterface
     */
    public function addResource(ResourceInterface $resource, array $parentResources = array());

    /**
     * Remove specified resource object from this ACL system.
     *
     * @param ResourceInterface $resource
     * @return ACLInterface
     */
    public function removeResource(ResourceInterface $resource);

    /**
     * Check if specified resource object is registered in this ACL system.
     *
     * @param ResourceInterface $resource
     * @return bool
     */
    public function hasResource(ResourceInterface $resource);

    /**
     * Register specifed resource as a child of specified parent resource. Both resources must be registered in this ACL before
     * calling this method.
     *
     * @param ResourceInterface $resource
     * @param ResourceInterface $parentResource
     * @return ACLInterface
     */
    public function addResourceParent(ResourceInterface $resource, ResourceInterface $parentResource);

    /**
     * Remove specifed resource from children's list of specified parent resource.
     *
     * @param ResourceInterface $resource
     * @param ResourceInterface $parentResource
     * @return ACLInterface
     */
    public function removeResourceParent(ResourceInterface $resource, ResourceInterface $parentResource);

    /**
     * Remove specified resource form children's list of all its current parent resources.
     *
     * @param ResourceInterface $resource
     * @return ACLInterface
     */
    public function removeResourceParents(ResourceInterface $resource);

    /**
     * Check if specified resource is child of specified parent resource.
     *
     * @param ResourceInterface $resource
     * @param ResourceInterface $parentResource
     * @return bool
     */
    public function isResourceParent(ResourceInterface $resource, ResourceInterface $parentResource);

    /**
     * Return array of all parent resources of specified resource.
     *
     * @param ResourceInterface $resource
     * @return ResourceInterface[]
     */
    public function getResourceParents(ResourceInterface $resource);

    /**
     * Return array of all children resources of specified resource.
     *
     * @param ResourceInterface $parentResource
     * @return ResourceInterface[]
     */
    public function getResourceChildren(ResourceInterface $parentResource);

    /**
     * Return array of all registered resource objects which are instances of specified class.
     *
     * @param string $className
     * @return ResourceInterface[]
     */
    public function getResourcesByClass($className);

    /**
     * Add new ACE object to this ACL system.
     *
     * @param ACEInterface $ace
     * @return ACLInterface
     */
    public function addACE(ACEInterface $ace);

    /**
     * Remove specified ACE object from this ACL system.
     *
     * @param ACEInterface $ace
     * @return ACLInterface
     */
    public function removeACE(ACEInterface $ace);

    /**
     * Check if specified ACE object is registered in this ACL system.
     *
     * @param ACEInterface $ace
     * @return bool
     */
    public function hasACE(ACEInterface $ace);

    /**
     * Check access right to the specified permission of the specified resource for the specified role.
     *
     * @param RoleInterface $role
     * @param ResourceInterface $resource
     * @param PermissionInterface $permission
     * @param array $params
     * @return bool
     */
    public function isAllowed(RoleInterface $role, ResourceInterface $resource, PermissionInterface $permission, array $params = array());
}
