<?php

namespace Lpsa\MailBundle\Service;

use Doctrine\Common\Persistence\ObjectManager;
use Lpsa\MailBundle\Entity\MailHistory;

class MailManager {
    
    /**
     * @var SwiftMailer
     */
    protected $mailer;

    /**
     * @var ObjectManager
     */
    protected $em;

    public function __construct(\Swift_Mailer $mailer, ObjectManager $em)
    {
        $this->mailer = $mailer;
        $this->em = $em;
    }
   
    private function addToQueue($from, $to,$subject,$body,$user,$event = null,$sendingDate = null)
    {
        try {
            $mail = new MailHistory();
            $mail->setMailFrom($from);
            $mail->setMailTo($to);
            $mail->setSubject($subject);
            $mail->setBody($body);
            $mail->setUser($user);
            $mail->setEvenement($event);

            if (! is_null($sendingDate)) {
                $mail->setSendingDate($sendingDate);
            }

            $this->em->persist($mail);
            
        } catch (\Exception $error) {
            throw $error;
        }

        return $mail;
    }
    
    public function sendEmail($from, $to,$subject,$body,$user,$event = null,$sendingDate = null)
    {
        try {
            $mail = $this->addToQueue($from, $to, $subject, $body, $user, $event, $sendingDate);
            // create a swift message
            $message = \Swift_Message::newInstance();
            $message
                    ->setSubject($mail->getSubject())
                    ->setFrom($mail->getMailFrom())
                    ->setTo($mail->getMailTo())
                    ->setBody($mail->getBody(), 'text/html');

            $sent = $this->mailer->send($message);
            $mail->setSent($sent);
            
            return $sent;
        } catch (\Exception $error) {
            throw $error;
        }
    }
    
    public function flush(){
        $this->em->flush();
    }
}
