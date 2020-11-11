<?php

namespace App\Entity;

use App\Repository\AdRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AdRepository::class)
 */
class Ad
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Profession::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $profession;

    /**
     * @ORM\ManyToOne(targetEntity=AdType::class, inversedBy="ads")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
*/
    private $remunerationType;

    /**
     * @ORM\Column(type="boolean")
     */
    private $haveSecretariat;

    /**
     * @ORM\Column(type="boolean")
     */
    private $homeVisit;

    /**
     * @ORM\Column(type="boolean")
     */
    private $housing;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $appointments;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $software;

    /**
     * @ORM\Column(type="boolean")
     */
    private $houseKeeping;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sector;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="ads")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Picture::class, mappedBy="ad", orphanRemoval=true)
     */
    private $pictures;

    /**
     * @ORM\OneToMany(targetEntity=AdHistory::class, mappedBy="ad")
     */
    private $adHistories;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\OneToMany(targetEntity=Response::class, mappedBy="ad", orphanRemoval=true)
     */
    private $responses;

    /**
     * @ORM\OneToMany(targetEntity=Paiement::class, mappedBy="ad")
     */
    private $paiements;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contact;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phoneNumber;

    public function __construct()
    {
        $this->pictures = new ArrayCollection();
        $this->adHistories = new ArrayCollection();
        $this->responses = new ArrayCollection();
        $this->paiements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProfession(): ?Profession
    {
        return $this->profession;
    }

    public function setProfession(?Profession $profession): self
    {
        $this->profession = $profession;

        return $this;
    }

    public function getType(): ?AdType
    {
        return $this->type;
    }

    public function setType(?AdType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getRemunerationType(): ?string
    {
        return $this->remunerationType;
    }

    public function setRemunerationType(?string $remunerationType): self
    {
        $this->remunerationType = $remunerationType;

        return $this;
    }

    public function getHaveSecretariat(): ?bool
    {
        return $this->haveSecretariat;
    }

    public function setHaveSecretariat(bool $haveSecretariat): self
    {
        $this->haveSecretariat = $haveSecretariat;

        return $this;
    }

    public function getHomeVisit(): ?bool
    {
        return $this->homeVisit;
    }

    public function setHomeVisit(bool $homeVisit): self
    {
        $this->homeVisit = $homeVisit;

        return $this;
    }

    public function getHousing(): ?bool
    {
        return $this->housing;
    }

    public function setHousing(bool $housing): self
    {
        $this->housing = $housing;

        return $this;
    }

    public function getAppointments(): ?string
    {
        return $this->appointments;
    }

    public function setAppointments(?string $appointments): self
    {
        $this->appointments = $appointments;

        return $this;
    }

    public function getSoftware(): ?string
    {
        return $this->software;
    }

    public function setSoftware(?string $software): self
    {
        $this->software = $software;

        return $this;
    }

    public function getHouseKeeping(): ?bool
    {
        return $this->houseKeeping;
    }

    public function setHouseKeeping(bool $houseKeeping): self
    {
        $this->houseKeeping = $houseKeeping;

        return $this;
    }

    public function getSector(): ?string
    {
        return $this->sector;
    }

    public function setSector(?string $sector): self
    {
        $this->sector = $sector;

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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

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

    /**
     * @return Collection|Picture[]
     */
    public function getPictures(): Collection
    {
        return $this->pictures;
    }

    public function addPicture(Picture $picture): self
    {
        if (!$this->pictures->contains($picture)) {
            $this->pictures[] = $picture;
            $picture->setAd($this);
        }

        return $this;
    }

    public function removePicture(Picture $picture): self
    {
        if ($this->pictures->contains($picture)) {
            $this->pictures->removeElement($picture);
            // set the owning side to null (unless already changed)
            if ($picture->getAd() === $this) {
                $picture->setAd(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|AdHistory[]
     */
    public function getAdHistories(): Collection
    {
        return $this->adHistories;
    }

    public function addAdHistory(AdHistory $adHistory): self
    {
        if (!$this->adHistories->contains($adHistory)) {
            $this->adHistories[] = $adHistory;
            $adHistory->setAd($this);
        }

        return $this;
    }

    public function removeAdHistory(AdHistory $adHistory): self
    {
        if ($this->adHistories->contains($adHistory)) {
            $this->adHistories->removeElement($adHistory);
            // set the owning side to null (unless already changed)
            if ($adHistory->getAd() === $this) {
                $adHistory->setAd(null);
            }
        }

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

    /**
     * @return Collection|Response[]
     */
    public function getResponses(): Collection
    {
        return $this->responses;
    }

    public function addResponse(Response $response): self
    {
        if (!$this->responses->contains($response)) {
            $this->responses[] = $response;
            $response->setAd($this);
        }

        return $this;
    }

    public function removeResponse(Response $response): self
    {
        if ($this->responses->contains($response)) {
            $this->responses->removeElement($response);
            // set the owning side to null (unless already changed)
            if ($response->getAd() === $this) {
                $response->setAd(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Paiement[]
     */
    public function getPaiements(): Collection
    {
        return $this->paiements;
    }

    public function addPaiement(Paiement $paiement): self
    {
        if (!$this->paiements->contains($paiement)) {
            $this->paiements[] = $paiement;
            $paiement->setAd($this);
        }

        return $this;
    }

    public function removePaiement(Paiement $paiement): self
    {
        if ($this->paiements->contains($paiement)) {
            $this->paiements->removeElement($paiement);
            // set the owning side to null (unless already changed)
            if ($paiement->getAd() === $this) {
                $paiement->setAd(null);
            }
        }

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

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

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(?string $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(?string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }
}
