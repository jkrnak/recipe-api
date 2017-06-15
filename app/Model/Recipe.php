<?php

namespace App\Model;

class Recipe
{
    /** @var int */
    private $id;
    /** @var \DateTimeImmutable */
    private $createdAt;
    /** @var \DateTimeImmutable */
    private $updatedAt;
    /** @var string */
    private $boxType;
    /** @var string */
    private $title;
    /** @var string */
    private $slug;
    /** @var string */
    private $shortTitle;
    /** @var string */
    private $marketingDescription;
    /** @var int */
    private $caloriesKcal;
    /** @var int */
    private $proteinGrams;
    /** @var int */
    private $fatGrams;
    /** @var int */
    private $carbsGrams;
    /** @var string */
    private $bulletpoint1;
    /** @var string */
    private $bulletpoint2;
    /** @var string */
    private $bulletpoint3;
    /** @var string */
    private $recipeDietTypeId;
    /** @var string */
    private $season;
    /** @var string */
    private $base;
    /** @var string */
    private $proteinSource;
    /** @var int */
    private $preparationTimeMinutes;
    /** @var int */
    private $shelfLifeDays;
    /** @var string */
    private $equipmentNeeded;
    /** @var string */
    private $originCountry;
    /** @var string */
    private $recipeCuisine;
    /** @var string[] */
    private $inYourBox = [];
    /** @var int */
    private $goustoReference;

    public function __construct()
    {
        $this->setCreatedAt(new \DateTimeImmutable());
        $this->setUpdatedAt(new \DateTimeImmutable());
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Recipe
     */
    public function setId(int $id): Recipe
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTimeImmutable $createdAt
     * @return Recipe
     */
    public function setCreatedAt(\DateTimeImmutable $createdAt): Recipe
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTimeImmutable $updatedAt
     * @return Recipe
     */
    public function setUpdatedAt(\DateTimeImmutable $updatedAt): Recipe
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return string
     */
    public function getBoxType(): ?string
    {
        return $this->boxType;
    }

    /**
     * @param string $boxType
     * @return Recipe
     */
    public function setBoxType(string $boxType): Recipe
    {
        $this->boxType = $boxType;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Recipe
     */
    public function setTitle(string $title): Recipe
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     * @return Recipe
     */
    public function setSlug(string $slug): Recipe
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return string
     */
    public function getShortTitle(): ?string
    {
        return $this->shortTitle;
    }

    /**
     * @param string $shortTitle
     * @return Recipe
     */
    public function setShortTitle(string $shortTitle): Recipe
    {
        $this->shortTitle = $shortTitle;
        return $this;
    }

    /**
     * @return string
     */
    public function getMarketingDescription(): ?string
    {
        return $this->marketingDescription;
    }

    /**
     * @param string $marketingDescription
     * @return Recipe
     */
    public function setMarketingDescription(string $marketingDescription): Recipe
    {
        $this->marketingDescription = $marketingDescription;
        return $this;
    }

    /**
     * @return int
     */
    public function getCaloriesKcal(): ?int
    {
        return $this->caloriesKcal;
    }

    /**
     * @param int $caloriesKcal
     * @return Recipe
     */
    public function setCaloriesKcal(int $caloriesKcal): Recipe
    {
        $this->caloriesKcal = $caloriesKcal;
        return $this;
    }

    /**
     * @return int
     */
    public function getProteinGrams(): ?int
    {
        return $this->proteinGrams;
    }

    /**
     * @param int $proteinGrams
     * @return Recipe
     */
    public function setProteinGrams(int $proteinGrams): Recipe
    {
        $this->proteinGrams = $proteinGrams;
        return $this;
    }

    /**
     * @return int
     */
    public function getFatGrams(): ?int
    {
        return $this->fatGrams;
    }

    /**
     * @param int $fatGrams
     * @return Recipe
     */
    public function setFatGrams(int $fatGrams): Recipe
    {
        $this->fatGrams = $fatGrams;
        return $this;
    }

    /**
     * @return int
     */
    public function getCarbsGrams(): ?int
    {
        return $this->carbsGrams;
    }

    /**
     * @param int $carbsGrams
     * @return Recipe
     */
    public function setCarbsGrams(int $carbsGrams): Recipe
    {
        $this->carbsGrams = $carbsGrams;
        return $this;
    }

    /**
     * @return string
     */
    public function getBulletpoint1(): ?string
    {
        return $this->bulletpoint1;
    }

    /**
     * @param string $bulletpoint1
     * @return Recipe
     */
    public function setBulletpoint1(string $bulletpoint1): Recipe
    {
        $this->bulletpoint1 = $bulletpoint1;
        return $this;
    }

    /**
     * @return string
     */
    public function getBulletpoint2(): ?string
    {
        return $this->bulletpoint2;
    }

    /**
     * @param string $bulletpoint2
     * @return Recipe
     */
    public function setBulletpoint2(string $bulletpoint2): Recipe
    {
        $this->bulletpoint2 = $bulletpoint2;
        return $this;
    }

    /**
     * @return string
     */
    public function getBulletpoint3(): ?string
    {
        return $this->bulletpoint3;
    }

    /**
     * @param string $bulletpoint3
     * @return Recipe
     */
    public function setBulletpoint3(string $bulletpoint3): Recipe
    {
        $this->bulletpoint3 = $bulletpoint3;
        return $this;
    }

    /**
     * @return string
     */
    public function getRecipeDietTypeId(): ?string
    {
        return $this->recipeDietTypeId;
    }

    /**
     * @param string $recipeDietTypeId
     * @return Recipe
     */
    public function setRecipeDietTypeId(string $recipeDietTypeId): Recipe
    {
        $this->recipeDietTypeId = $recipeDietTypeId;
        return $this;
    }

    /**
     * @return string
     */
    public function getSeason(): ?string
    {
        return $this->season;
    }

    /**
     * @param string $season
     * @return Recipe
     */
    public function setSeason(string $season): Recipe
    {
        $this->season = $season;
        return $this;
    }

    /**
     * @return string
     */
    public function getBase(): ?string
    {
        return $this->base;
    }

    /**
     * @param string $base
     * @return Recipe
     */
    public function setBase(string $base): Recipe
    {
        $this->base = $base;
        return $this;
    }

    /**
     * @return string
     */
    public function getProteinSource(): ?string
    {
        return $this->proteinSource;
    }

    /**
     * @param string $proteinSource
     * @return Recipe
     */
    public function setProteinSource(string $proteinSource): Recipe
    {
        $this->proteinSource = $proteinSource;
        return $this;
    }

    /**
     * @return int
     */
    public function getPreparationTimeMinutes(): ?int
    {
        return $this->preparationTimeMinutes;
    }

    /**
     * @param int $preparationTimeMinutes
     * @return Recipe
     */
    public function setPreparationTimeMinutes(int $preparationTimeMinutes): Recipe
    {
        $this->preparationTimeMinutes = $preparationTimeMinutes;
        return $this;
    }

    /**
     * @return int
     */
    public function getShelfLifeDays(): ?int
    {
        return $this->shelfLifeDays;
    }

    /**
     * @param int $shelfLifeDays
     * @return Recipe
     */
    public function setShelfLifeDays(int $shelfLifeDays): Recipe
    {
        $this->shelfLifeDays = $shelfLifeDays;
        return $this;
    }

    /**
     * @return string
     */
    public function getEquipmentNeeded(): ?string
    {
        return $this->equipmentNeeded;
    }

    /**
     * @param string $equipmentNeeded
     * @return Recipe
     */
    public function setEquipmentNeeded(string $equipmentNeeded): Recipe
    {
        $this->equipmentNeeded = $equipmentNeeded;
        return $this;
    }

    /**
     * @return string
     */
    public function getOriginCountry(): ?string
    {
        return $this->originCountry;
    }

    /**
     * @param string $originCountry
     * @return Recipe
     */
    public function setOriginCountry(string $originCountry): Recipe
    {
        $this->originCountry = $originCountry;
        return $this;
    }

    /**
     * @return string
     */
    public function getRecipeCuisine(): ?string
    {
        return $this->recipeCuisine;
    }

    /**
     * @param string $recipeCuisine
     * @return Recipe
     */
    public function setRecipeCuisine(string $recipeCuisine): Recipe
    {
        $this->recipeCuisine = $recipeCuisine;
        return $this;
    }

    /**
     * @return \string[]
     */
    public function getInYourBox(): array
    {
        return $this->inYourBox;
    }

    /**
     * @param \string[] $inYourBox
     * @return Recipe
     */
    public function setInYourBox(array $inYourBox): Recipe
    {
        $this->inYourBox = $inYourBox;
        return $this;
    }

    /**
     * @return int
     */
    public function getGoustoReference(): ?int
    {
        return $this->goustoReference;
    }

    /**
     * @param int $goustoReference
     * @return Recipe
     */
    public function setGoustoReference(int $goustoReference): Recipe
    {
        $this->goustoReference = $goustoReference;
        return $this;
    }
}
