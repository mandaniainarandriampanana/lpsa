<?php
namespace Lpsa\AppBundle\EventListener;

use Lpsa\AppBundle\Event\ServiceManagerEvent;
use Lpsa\MailBundle\Service\MailManager;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

class ServiceManagerListener {
    
    private $entityEvent;
    private $actionProgress;
    private $mailer;
    private $templating;
    private $mailSite;
    const TEMPLATE = 'LpsaAppBundle:Mail:notification.html.twig';
    const SUBJECT = 'Ajout évènement';
    
    public function __construct(MailManager $mailer,EngineInterface $templating,$mailSite) {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->mailSite = $mailSite;
    }
    
    public function setActionProgress($actionProgress){
        $this->actionProgress = $actionProgress;
    }
    
    public function setEvent(ServiceManagerEvent $event)
    {
        $this->entityEvent  = $event->getEvent();
    }
    
    public function notify(){
        $users = $this->getUsers();
        if(!empty($users)){
            foreach($users as $user){
                $body = $this->templating->render(
                    self::TEMPLATE,
                    array('event' =>$this->entityEvent,'user' => $user)
                );
                $this->mailer->sendEmail($this->mailSite, $user->getEmail(),self::SUBJECT,$body,$user,$this->entityEvent);                
            }
            $this->mailer->flush();            
        }
    }
    
    private function getUsers(){
        $aUsers = array();
        foreach($this->entityEvent->getEvenementActionProgres() as $action){
            if ((false === $this->actionProgress->contains($action)) || empty($this->actionProgress)) {
                $serviceManager = $action->getResponsableService();
                $this->getListUsers($aUsers, $serviceManager);
            } 
        }
        return $aUsers;
    }
    
    private function getListUsers(&$aUsers,$serviceManager){
        if($serviceManager){
            $users = $serviceManager->getUsers();
            foreach ($users as $user){
                $aUsers[] = $user;
            }
        }        
    }
}
