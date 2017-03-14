<?php

namespace Lpsa\AppBundle\Form\Handler\Evenement;

use Lpsa\AppBundle\Entity\Evenement;
use Lpsa\AppBundle\Entity\Manager\Interfaces\EvenementManagerInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Doctrine\Common\Persistence\ObjectManager;
use Lpsa\AppBundle\Form\Type\Evenement\EvenementType;

abstract class AbstractEvenementFormHandlerStrategy implements EvenementFormHandlerStrategyInterface {
    /**
     * @var Form
     */
    protected $form;
 
    /**
     * @var EvenementManagerInterface
     */
    protected $evenementManager;
 
    /**
     * @var FormFactoryInterface
     */
    protected $formFactory;
 
    /**
     * @var RouterInterface $router
     */
    protected $router;
 
    /**
     * @var TranslatorInterface
     */
    protected $translator;
 
    /**
     * @var TokenStorageInterface 
     */
    protected $tokenStorage;
    /**
     *
     * @var EvenementType 
     */
    protected $evenementType;
    
    /**
     *
     * @var ObjectManager 
     */
    protected $em;
    
    /**
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(TokenStorageInterface $tokenStorage,EvenementType $evenementType,ObjectManager $em)
    {
        $this->tokenStorage = $tokenStorage;
        $this->evenementType = $evenementType;
        $this->em = $em;
    }
    
    /**
     * @param EvenementManagerInterface $evenementManager
     * @return AbstractEvenementFormHandlerStrategy
     */
    public function setEvenementManager($evenementManager)
    {
        $this->evenementManager = $evenementManager;
        return $this;
    }
    /**
     * @param FormFactoryInterface $formFactory
     * @return AbstractEvenementFormHandlerStrategy
     */
    public function setFormFactory($formFactory)
    {
        $this->formFactory = $formFactory;
        return $this;
    }
    /**
     * @param RouterInterface $router
     * @return AbstractEvenementFormHandlerStrategy
     */
    public function setRouter($router)
    {
        $this->router = $router;
        return $this;
    }
    /**
     * @param TranslatorInterface $translator
     * @return AbstractEvenementFormHandlerStrategy
     */
    public function setTranslator($translator)
    {
        $this->translator = $translator;
        return $this;
    }
    
    public function createView()
    {
        return $this->form->createView();
    }
    
    /**
     * Get the logged in user or null.
     *
     * @return User
     */
    public function getUser()
    {
        if (null === $token = $this->tokenStorage->getToken()) {
            throw new  AccessDeniedException('Access Denied.');
        }
 
        if (!is_object($user = $token->getUser())) {
            throw new  AccessDeniedException('Access Denied.');
        }
 
        return $user;
    }
    
    abstract public function handleForm(Request $request, Evenement $evenement);
 
    abstract public function createForm(Evenement $evenement);
}
