<?php

namespace Lpsa\AppBundle\Security;


use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Core\Role\RoleHierarchyInterface;

class RoleService
{
    private $roleHierarchy;

    /**
     * Constructor
     *
     * @param RoleHierarchyInterface $roleHierarchy
     */
    public function __construct(RoleHierarchyInterface $roleHierarchy)
    {
        $this->roleHierarchy = $roleHierarchy;
    }

    /**
     * isGranted
     *
     * @param string $role
     * @param $user
     * @return bool
     */
    public function isGranted($role, $user) {

        $oRole = new Role($role);
        
        foreach($user->getRoles() as $userRole) {
            if (in_array($oRole, $this->roleHierarchy->getReachableRoles(array(new Role($userRole))))) {
                return true;
            }
        }

        return false;
    }
}