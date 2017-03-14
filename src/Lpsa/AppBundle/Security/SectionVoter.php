<?php

namespace Lpsa\AppBundle\Security;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
 
class SectionVoter implements VoterInterface
{
    protected $container;
    protected $decisionManager;
 
    public function __construct(AccessDecisionManagerInterface $decisionManager,ContainerInterface $container)
    {
        $this->container = $container;
        $this->decisionManager = $decisionManager;
    }
 
    public function supportsAttribute($attribute)
    {
        return 'SECTION_CHECK' === $attribute;
    }
 
    public function supportsClass($class)
    {
        return true;
    }
 
    public function vote(TokenInterface $token, $object, array $attributes)
    {
        $support = false;
 
        foreach ($attributes as $attribute) {
            if ($this->supportsAttribute($attribute)) {
                $support = true;
            }
        }
 
        if (!$support) {
            return VoterInterface::ACCESS_ABSTAIN;
        }
 
        $user = $token->getUser();
 
        if (!$user instanceof UserInterface) {
            return VoterInterface::ACCESS_DENIED;
        }
 
        // ROLE_SUPER_ADMIN can do anything! 
        if ($this->decisionManager->decide($token, array('ROLE_SUPER_ADMIN'))) {
            return true;
        }
        
        $roles = $user->getRoles();
 
        $router = $this->container->get('router');
        $routeCollection = $router->getRouteCollection();
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $route = $routeCollection->get($request->get('_route'));
 
        $section = $route->getOption('section');
        foreach ($roles as $role) {
            if(is_array($section)){
                foreach($section as $sect){
                    if ($role == 'ROLE_' . strtoupper($sect)) {
                        return VoterInterface::ACCESS_GRANTED;
                    }
                }
            } else {
                if ($role == 'ROLE_' . strtoupper($section)) {
                    return VoterInterface::ACCESS_GRANTED;
                }
            }
        }
        return VoterInterface::ACCESS_DENIED;
    }
}