<?php

namespace App\Entity;

use App\Repository\UserAttributeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserAttributeRepository::class)
 */
class UserAttribute
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $attrName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $attrValue;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAttrName(): ?string
    {
        return $this->attrName;
    }

    public function setAttrName(string $attrName): self
    {
        $this->attrName = $attrName;

        return $this;
    }

    public function getAttrValue(): ?string
    {
        return $this->attrValue;
    }

    public function setAttrValue(?string $attrValue): self
    {
        $this->attrValue = $attrValue;

        return $this;
    }
}
