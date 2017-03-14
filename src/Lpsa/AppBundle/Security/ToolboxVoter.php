<?php

namespace Lpsa\AppBundle\Security;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Lpsa\AppBundle\Entity\Toolbox;
use Lpsa\UserBundle\Entity\User;

class ToolboxVoter extends Voter{

    const DOWNLOAD = 'download';
    private $decisionManager;
    private $roleService;

    public function __construct(AccessDecisionManagerInterface $decisionManager,RoleService $roleService)
    {
        $this->decisionManager = $decisionManager;
        $this->roleService = $roleService;
    }
    
    protected function supports($attribute, $subject) {
        if (!in_array($attribute, array(self::DOWNLOAD))) {
            return false;
        }
        
        // only vote on Toolbox objects inside this voter
        if (!$subject instanceof Toolbox) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }
        // ROLE_SUPER_ADMIN can do anything! 
        if ($this->decisionManager->decide($token, array('ROLE_SUPER_ADMIN'))) {
            return true;
        }
        
        switch ($attribute) {
            case self::DOWNLOAD:
                return $this->canDownload($subject, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canDownload(Toolbox $toolbox, User $user)
    {
        if($this->isAdminSite($toolbox,$user)){
            return true;
        } 
        return false;
    }

    private function isAdminSite(Toolbox $toolbox, User $user){
        //exception multiple roles 
        $roles = $user->getRoles();
        if(in_array('ROLE_KPIHSE',$roles)){
            return true;
        }
        return false;
    }
}
