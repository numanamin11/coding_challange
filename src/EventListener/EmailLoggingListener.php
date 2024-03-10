<?php

namespace App\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\Event\MessageEvent;
use App\Entity\EmailLog;
use Psr\Log\LoggerInterface;

class EmailLoggingListener
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, LoggerInterface $logger)
    {
        $this->entityManager = $entityManager;
        $this->logger = $logger;
    }

    public function onEmailSend(MessageEvent $event)
    {
        $email = $event->getMessage();

        if (!$email instanceof \Symfony\Component\Mime\Email) {
            return;
        }


        $log = new EmailLog();
        $log->setRecipientEmail(implode(', ', array_keys($email->getTo())));
        $log->setEmailSubject($email->getSubject());
        $log->setEmailContent($email->getHtmlBody());

        try{
            $this->logger->info('Email sent successfully', [
            'recipient' => implode(', ', array_keys($email->getTo())),
            'subject' => $email->getSubject(),
            ]);
            $log->setStatus('Sent'); 
        }catch (\Exception $e){

            $this->logger->error('Email sending failed', [
                'recipient' => implode(', ', array_keys($email->getTo())),
                'subject' => $email->getSubject(),
                'error' => $e->getMessage(),
            ]);

            $log->setStatus('Failed'); 
        }

        $this->entityManager->persist($log);
        $this->entityManager->flush();
    }
}
