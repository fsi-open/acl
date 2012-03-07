<?php

namespace FSi\ACL;

interface ACEInterface
{
    public function __construct(RoleInterface $role, ResourceInterface $resource, PermissionInterface $permission);

    public function getRole();

    public function getResource();

    public function getPermission();

    public function isAllowed();
}
