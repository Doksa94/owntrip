<?php

namespace App\Entity;

use App\Repository\ActivityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ActivityRepository::class)]
class Activity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: 'Champs Obligatoire')]
    #[ORM\Column(length: 255)]
    private ?string $name = null;


    #[ORM\Column]
    private ?int $first_price = null;


    #[ORM\Column]
    private ?int $max_price = null;


    #[ORM\Column(length: 255)]
    private ?string $tel = null;

    #[Assert\NotBlank(message: 'Champs Obligatoire')]
    #[ORM\Column(length: 255)]
    private ?string $street_number = null;

    #[Assert\NotBlank(message: 'Champs Obligatoire')]
    #[ORM\Column(length: 255)]
    private ?string $street_name = null;

    #[Assert\NotBlank(message: 'Champs Obligatoire')]
    #[ORM\Column]
    private ?int $zip_code = null;

    #[Assert\NotBlank(message: 'Champs Obligatoire')]
    #[ORM\ManyToMany(targetEntity: ActivityCategory::class, inversedBy: 'activities')]
    private Collection $category;

    #[Assert\NotBlank(message: 'Champs Obligatoire')]
    #[ORM\ManyToOne(inversedBy: 'activities')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ActivityType $type = null;

    #[Assert\NotBlank(message: 'Champs Obligatoire')]
    #[ORM\OneToMany(mappedBy: 'activity', targetEntity: Media::class)]
    private Collection $medias;

    #[Assert\NotBlank(message: 'Champs Obligatoire')]
    #[ORM\ManyToOne(inversedBy: 'activities')]
    #[ORM\JoinColumn(nullable: false)]
    private ?City $city = null;

    #[Assert\NotBlank(message: 'Champs Obligatoire')]
    #[ORM\ManyToMany(targetEntity: Package::class, mappedBy: 'activities')]
    private Collection $packages;

    #[Assert\NotBlank(message: 'Champs Obligatoire')]
    #[ORM\Column(nullable: true)]
    private ?int $duration = null;

    public function __construct()
    {
        $this->category = new ArrayCollection();
        $this->medias = new ArrayCollection();
        $this->packages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getFirstPrice(): ?int
    {
        return $this->first_price;
    }

    public function setFirstPrice(int $first_price): static
    {
        $this->first_price = $first_price;

        return $this;
    }

    public function getMaxPrice(): ?int
    {
        return $this->max_price;
    }

    public function setMaxPrice(int $max_price): static
    {
        $this->max_price = $max_price;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): static
    {
        $this->tel = $tel;

        return $this;
    }

    public function getStreetNumber(): ?string
    {
        return $this->street_number;
    }

    public function setStreetNumber(string $street_number): static
    {
        $this->street_number = $street_number;

        return $this;
    }

    public function getStreetName(): ?string
    {
        return $this->street_name;
    }

    public function setStreetName(string $street_name): static
    {
        $this->street_name = $street_name;

        return $this;
    }

    public function getZipCode(): ?int
    {
        return $this->zip_code;
    }

    public function setZipCode(int $zip_code): static
    {
        $this->zip_code = $zip_code;

        return $this;
    }

    /**
     * @return Collection<int, ActivityCategory>
     */
    public function getCategory(): Collection
    {
        return $this->category;
    }

    public function addCategory(ActivityCategory $category): static
    {
        if (!$this->category->contains($category)) {
            $this->category->add($category);
        }

        return $this;
    }

    public function removeCategory(ActivityCategory $category): static
    {
        $this->category->removeElement($category);

        return $this;
    }

    public function getType(): ?ActivityType
    {
        return $this->type;
    }

    public function setType(?ActivityType $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, Media>
     */
    public function getMedias(): Collection
    {
        return $this->medias;
    }

    public function addMedia(Media $media): static
    {
        if (!$this->medias->contains($media)) {
            $this->medias->add($media);
            $media->setActivity($this);
        }

        return $this;
    }

    public function removeMedia(Media $media): static
    {
        if ($this->medias->removeElement($media)) {
            // set the owning side to null (unless already changed)
            if ($media->getActivity() === $this) {
                $media->setActivity(null);
            }
        }

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): static
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return Collection<int, Package>
     */
    public function getPackages(): Collection
    {
        return $this->packages;
    }

    public function addPackage(Package $package): static
    {
        if (!$this->packages->contains($package)) {
            $this->packages->add($package);
            $package->addActivity($this);
        }

        return $this;
    }

    public function removePackage(Package $package): static
    {
        if ($this->packages->removeElement($package)) {
            $package->removeActivity($this);
        }

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(?int $duration): static
    {
        $this->duration = $duration;

        return $this;
    }
}
