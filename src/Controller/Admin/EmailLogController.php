<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\EmailLog;

class EmailLogController extends AbstractController
{
    /**
     * @Route("/admin/email-logs", name="admin_email_logs")
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $emailLogs = $entityManager->getRepository(EmailLog::class)->findAll();

        return $this->render('admin/email_log/index.html.twig', [
            'emailLogs' => $emailLogs,
        ]);
    }

    /**
     * @Route("/admin/email-log/resend/{id}", name="admin_email_log_resend")
     */
    public function resendEmail(int $id, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        $emailLog = $entityManager->getRepository(EmailLog::class)->find($id);

        if (!$emailLog) {
            $this->addFlash('error', 'Email log not found.');
            return $this->redirectToRoute('admin_email_logs');
        }

        $email = (new Email())
            ->from('your_email@example.com') // Adjust as necessary
            ->to($emailLog->getRecipientEmail())
            ->subject($emailLog->getEmailSubject())
            ->html($emailLog->getEmailContent());

        try {
            $mailer->send($email);
            $this->addFlash('success', 'Email has been resent successfully.');
        } catch (\Exception $e) {
            // Log the error or handle it as necessary
            $this->addFlash('error', 'Failed to resend email.');
        }

        return $this->redirectToRoute('admin_email_logs');
    }
}
