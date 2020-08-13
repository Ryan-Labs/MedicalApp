<?php

namespace App\Entity;

use App\Repository\ResponseRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ResponseRepository::class)
 */
class Response
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="responses")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Ad::class, inversedBy="responses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ad;

    /**
     * @ORM\Column(type="blob", nullable=true)
     */
    private $file1;

    /**
     * @ORM\Column(type="blob", nullable=true)
     */
    private $file2;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\OneToOne(targetEntity=Mail::class, mappedBy="response", cascade={"persist", "remove"})
     */
    private $mail;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAd(): ?Ad
    {
        return $this->ad;
    }

    public function setAd(?Ad $ad): self
    {
        $this->ad = $ad;

        return $this;
    }

    public function getFile1()
    {
        return $this->file1;
    }

    public function setFile1($file1): self
    {
        $this->file1 = $file1;

        return $this;
    }

    public function getFile2()
    {
        return $this->file2;
    }

    public function setFile2($file2): self
    {
        $this->file2 = $file2;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getMail(): ?Mail
    {
        return $this->mail;
    }

    public function setMail(Mail $mail): self
    {
        $this->mail = $mail;

        // set the owning side of the relation if necessary
        if ($mail->getResponse() !== $this) {
            $mail->setResponse($this);
        }

        return $this;
    }
}
