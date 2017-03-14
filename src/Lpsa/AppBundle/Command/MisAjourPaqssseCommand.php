<?php
namespace Lpsa\AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class MisAjourPaqssseCommand extends ContainerAwareCommand{
    protected function configure(){
        $this
             ->setName('maj:paqssse')
             ->setDescription('Mis a jour PAQSSSE.')
             ->setHelp('cette commande met à jour la table evenement en remplissant le champ isPaqssse de la table Paq3se à true si la date d\'operation depasse le 30 jours')
        ;
    }
     protected function execute(InputInterface $input, OutputInterface $output){
        $AllEvent = $this->getContainer()->get('app.evenement.manager')->getRepository()->findAllNotPaqssse();
        $now = new \DateTime('now');
        $compteMaj = 0;
        foreach ($AllEvent as $event){
            $dateEmission = $event->getDateEmission();
            if($dateEmission != null){
                $interval = date_diff($dateEmission,$now)->format('%R%a');
                if($event->getEvenementStatut() != null){
                   if(intval($interval)>30 && $event->getPaq3se()->getIsPaqssse() == false && $event->getEvenementStatut()->getId() == 1){ //change when statut "en cours" id change (actually 1) 
                        $event->getPaq3se()->setIsPaqssse(true);
                        $this->getContainer()->get('app.evenement.manager')->getRepository()->save($event);
                        $compteMaj++;
                    } 
                }
            }
        }
        $output->write($compteMaj." evenements ont ete mis au paqssse!");
    }
     
}
