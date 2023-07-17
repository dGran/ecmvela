<?php

declare(strict_types=1);

namespace App\Entity;

use App\Helper\Helper;
use App\Repository\PetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PetRepository::class)]
class Pet
{
    public const PROFILE_TYPE_DOG_IMG_PATH = 'img/pets/dogs/';
    public const DEFAULT_PROFILE_TYPE_DOG_IMG_PATH = 'build/app/img/pets/dog-no-image.png';

    public const PROFILE_TYPE_CAT_IMG_PATH = 'img/pets/cats/';
    public const DEFAULT_PROFILE_TYPE_CAT_IMG_PATH = 'build/app/img/pets/cat-no-image.png';

    public const PROFILE_TYPE_RABBIT_IMG_PATH = 'img/pets/rabbits/';
    public const DEFAULT_PROFILE_TYPE_RABBIT_IMG_PATH = 'build/app/img/pets/rabbit-no-image.png';

    #[ORM\Id]
    #[ORM\GeneratedValue('AUTO')]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 60)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 60)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'pets')]
    #[ORM\JoinColumn]
    private ?Customer $customer = null;

    #[ORM\ManyToOne(inversedBy: 'pets')]
    #[ORM\JoinColumn]
    #[Assert\NotBlank]
    private ?PetCategory $category = null;

    #[ORM\ManyToOne(inversedBy: 'pets')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Breed $breed = null;

    #[ORM\Column(length: 60, nullable: true)]
    #[Assert\Length(max: 60)]
    private ?string $color = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $birthDate = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(max: 255)]
    private ?string $profileImg = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $notes = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateRecommendedNextService = null;

    #[ORM\Column]
    private bool $active = true;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateAdd;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateUpd = null;

    #[ORM\OneToMany(mappedBy: 'pet', targetEntity: Sale::class)]
    private Collection $sales;

    #[ORM\Column(nullable: true)]
    private ?int $weeksRecommendedPeriodicity = null;

    #[ORM\Column(nullable: true)]
    private ?float $maitenancePlanPrice = null;

    #[ORM\OneToMany(mappedBy: 'pet', targetEntity: SaleLine::class)]
    private Collection $saleLines;

    #[ORM\OneToMany(mappedBy: 'pet', targetEntity: Booking::class)]
    private Collection $bookings;

    public function __construct()
    {
        $this->dateAdd = new \DateTime();
        $this->sales = new ArrayCollection();
        $this->saleLines = new ArrayCollection();
        $this->bookings = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Pet
    {
        $this->name = $name;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(Customer $customer): Pet
    {
        $this->customer = $customer;

        return $this;
    }

    public function getCategory(): ?PetCategory
    {
        return $this->category;
    }

    public function setCategory(PetCategory $category): Pet
    {
        $this->category = $category;

        return $this;
    }

    public function getBreed(): ?Breed
    {
        return $this->breed;
    }

    public function setBreed(?Breed $breed): Pet
    {
        $this->breed = $breed;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): Pet
    {
        $this->color = $color;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(?\DateTimeInterface $birthDate): void
    {
        $this->birthDate = $birthDate;
    }

    public function getProfileImg(): ?string
    {
        return $this->profileImg;
    }

    public function setProfileImg(?string $profileImg): Pet
    {
        $this->profileImg = $profileImg;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): void
    {
        $this->notes = $notes;
    }

    public function getDateRecommendedNextService(): ?\DateTimeInterface
    {
        return $this->dateRecommendedNextService;
    }

    public function setDateRecommendedNextService(?\DateTimeInterface $dateRecommendedNextService): Pet
    {
        $this->dateRecommendedNextService = $dateRecommendedNextService;

        return $this;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): Pet
    {
        $this->active = $active;

        return $this;
    }

    public function getDateAdd(): \DateTimeInterface
    {
        return $this->dateAdd;
    }

    public function setDateAdd(\DateTimeInterface $dateAdd): Pet
    {
        $this->dateAdd = $dateAdd;

        return $this;
    }

    public function getDateUpd(): ?\DateTimeInterface
    {
        return $this->dateUpd;
    }

    public function setDateUpd(\DateTimeInterface $dateUpd): Pet
    {
        $this->dateUpd = $dateUpd;

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function getProfileImgPath(): ?string
    {
        if (!$this->getCategory()) {
            return null;
        }

        $image = $this->profileImg;

        if ($image && !\file_exists(self::PROFILE_TYPE_DOG_IMG_PATH.$image)) {
            return Helper::BROKEN_IMAGE_PATH;
        }

        switch ($this->getCategory()->getId()) {
            case PetCategory::TYPE_DOG_ID:
                if ($image) {
                    return self::PROFILE_TYPE_DOG_IMG_PATH.$image;
                }

                return self::DEFAULT_PROFILE_TYPE_DOG_IMG_PATH;
            case PetCategory::TYPE_CAT_ID:
                if ($image) {
                    return self::PROFILE_TYPE_CAT_IMG_PATH.$image;
                }

                return self::DEFAULT_PROFILE_TYPE_CAT_IMG_PATH;
            case PetCategory::TYPE_RABBIT_ID:
                if ($image) {
                    return self::PROFILE_TYPE_RABBIT_IMG_PATH.$image;
                }

                return self::DEFAULT_PROFILE_TYPE_RABBIT_IMG_PATH;
            default:
                return self::DEFAULT_PROFILE_TYPE_DOG_IMG_PATH;
        }
    }

    public function getDefaultImgPath(): ?string
    {
        if (!$this->getCategory()) {
            return null;
        }

        return match ($this->getCategory()->getId()) {
            PetCategory::TYPE_CAT_ID => self::DEFAULT_PROFILE_TYPE_CAT_IMG_PATH,
            PetCategory::TYPE_RABBIT_ID => self::DEFAULT_PROFILE_TYPE_RABBIT_IMG_PATH,
            default => self::DEFAULT_PROFILE_TYPE_DOG_IMG_PATH,
        };
    }

    public function getProfileImgDir(): ?string
    {
        if (!$this->getCategory()) {
            return '';
        }

        return match ($this->getCategory()->getId()) {
            PetCategory::TYPE_CAT_ID => self::PROFILE_TYPE_CAT_IMG_PATH,
            PetCategory::TYPE_RABBIT_ID => self::PROFILE_TYPE_RABBIT_IMG_PATH,
            default => self::PROFILE_TYPE_DOG_IMG_PATH,
        };
    }

    public function getPetFullAge(): ?string
    {
        if (!$this->active) {
            if ($this->birthDate !== null) {
                return date_format($this->birthDate, "d/m/Y");
            }

            return null;
        }

        if ($this->birthDate !== null) {
            try {
                $helper = new Helper();
                $age = $helper->getDifferenceBetweenDates(\DateTime::createFromInterface($this->birthDate), new \DateTime());

            } catch (\Throwable $exception) {
                dump($exception->getMessage());die;
            }
        }

        return $age ?? null;
    }

    public function getPetShortAge(): ?string
    {
        if (!$this->active) {
            if ($this->birthDate !== null) {
                return date_format($this->birthDate, "d/m/Y");
            }

            return null;
        }

        $age = null;

        if ($this->birthDate !== null) {
            $currentDate = new \DateTime();
            $difference = $currentDate->diff($this->birthDate);

            if ($difference->y) {
                $age .= $difference->format("%y");
                $age .= $difference->y === 1 ? ' año' : ' años';

                return $age;
            }

            if ($difference->m) {
                $age .= $difference->format("%m");
                $age .= $difference->m === 1 ? ' mes' : ' meses';

                return $age;
            }

            if ($difference->d) {
                $age .= $difference->format("%d");
                $age .= $difference->d === 1 ? ' día' : ' días';

                return $age;
            }
        }

        return '-';
    }

    /**
     * @return Collection<int, Sale>
     */
    public function getSales(): Collection
    {
        return $this->sales;
    }

    public function addSale(Sale $sale): self
    {
        if (!$this->sales->contains($sale)) {
            $this->sales->add($sale);
            $sale->setPet($this);
        }

        return $this;
    }

    public function removeSale(Sale $sale): self
    {
        // set the owning side to null (unless already changed)
        if ($this->sales->removeElement($sale) && $sale->getPet() === $this) {
            $sale->setPet(null);
        }

        return $this;
    }

    public function getWeeksRecommendedPeriodicity(): ?int
    {
        return $this->weeksRecommendedPeriodicity;
    }

    public function setWeeksRecommendedPeriodicity(?int $weeksRecommendedPeriodicity): self
    {
        $this->weeksRecommendedPeriodicity = $weeksRecommendedPeriodicity;

        return $this;
    }

    public function getMaitenancePlanPrice(): ?float
    {
        return $this->maitenancePlanPrice;
    }

    public function setMaitenancePlanPrice(?float $maitenancePlanPrice): self
    {
        $this->maitenancePlanPrice = $maitenancePlanPrice;

        return $this;
    }

    /**
     * @return Collection<int, SaleLine>
     */
    public function getSaleLines(): Collection
    {
        return $this->saleLines;
    }

    public function addSaleLine(SaleLine $saleLine): self
    {
        if (!$this->saleLines->contains($saleLine)) {
            $this->saleLines->add($saleLine);
            $saleLine->setPet($this);
        }

        return $this;
    }

    public function removeSaleLine(SaleLine $saleLine): self
    {
        // set the owning side to null (unless already changed)
        if ($this->saleLines->removeElement($saleLine) && $saleLine->getPet() === $this) {
            $saleLine->setPet(null);
        }

        return $this;
    }

    /**
     * @return Collection<int, Booking>
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings->add($booking);
            $booking->setPet($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        // set the owning side to null (unless already changed)
        if ($this->bookings->removeElement($booking) && $booking->getPet() === $this) {
            $booking->setPet(null);
        }

        return $this;
    }
}