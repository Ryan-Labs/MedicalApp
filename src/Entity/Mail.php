<?php

namespace App\Entity;

use App\Repository\MailRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Mailer\MailerInterface;

/**
 * @ORM\Entity(repositoryClass=MailRepository::class)
 */
class Mail
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Response::class, inversedBy="mail", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $response;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sender;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $recipient;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $CC;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $BCC;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subject;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="mails")
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

    public function __construct(?Response $response, ?string $sender, ?string $recipient, ?string $CC, ?string $BCC, ?string $subject, ?string $content, MailRepository $mailRepository, MailerInterface $mailer, EntityManagerInterface $entityManager, ?User $user)
    {
        $this->response = $response;
        $this->sender = $sender;
        $this->recipient = $recipient;
        $this->CC = $CC;
        $this->BCC = $BCC;
        $this->subject = $subject;
        $this->content = $content;
        $this->user = $user;

        $this->date = new DateTime();

        $entityManager->persist($this);
        $entityManager->flush();

        $mailRepository->sendMail($this, $mailer);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getResponse(): ?Response
    {
        return $this->response;
    }

    public function setResponse(Response $response): self
    {
        $this->response = $response;

        return $this;
    }

    public function getSender(): ?string
    {
        return $this->sender;
    }

    public function setSender(string $sender): self
    {
        $this->sender = $sender;

        return $this;
    }

    public function getRecipient(): ?string
    {
        return $this->recipient;
    }

    public function setRecipient(string $recipient): self
    {
        $this->recipient = $recipient;

        return $this;
    }

    public function getCC(): ?string
    {
        return $this->CC;
    }

    public function setCC(?string $CC): self
    {
        $this->CC = $CC;

        return $this;
    }

    public function getBCC(): ?string
    {
        return $this->BCC;
    }

    public function setBCC(?string $BCC): self
    {
        $this->BCC = $BCC;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(?string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
