<?php 

// src/Entity/EmailLog.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="email_logs")
 */
class EmailLog
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /** 
     * @ORM\Column(type="string") 
     */
    private $recipientEmail;

    /** 
     * @ORM\Column(type="string") 
     */
    private $emailSubject;

    /** 
     * @ORM\Column(type="datetime") 
     */
    private $dateTime;

    /** 
     * @ORM\Column(type="string") 
     */
    private $status;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $emailContent; // Additional property for email content

    public function __construct(string $recipientEmail, string $emailSubject, \DateTimeInterface $dateTime, string $status, string $emailContent = null)
    {
        $this->recipientEmail = $recipientEmail;
        $this->emailSubject = $emailSubject;
        $this->dateTime = $dateTime;
        $this->status = $status;
        $this->emailContent = $emailContent;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRecipientEmail(): ?string
    {
        return $this->recipientEmail;
    }

    public function setRecipientEmail(string $recipientEmail): self
    {
        $this->recipientEmail = $recipientEmail;
        return $this;
    }

    public function getEmailSubject(): ?string
    {
        return $this->emailSubject;
    }

    public function setEmailSubject(string $emailSubject): self
    {
        $this->emailSubject = $emailSubject;
        return $this;
    }

    public function getDateTime(): ?\DateTimeInterface
    {
        return $this->dateTime;
    }

    public function setDateTime(\DateTimeInterface $dateTime): self
    {
        $this->dateTime = $dateTime;
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getEmailContent(): ?string
    {
        return $this->emailContent;
    }

    public function setEmailContent(?string $emailContent): self
    {
        $this->emailContent = $emailContent;
        return $this;
    }
}
