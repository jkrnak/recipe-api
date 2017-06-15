<?php

namespace App\Model\Repository;

use App\Model\Recipe;

/**
 * CSV backed recipe storage layer implementation
 */
class CsvRecipeRepository implements RecipeRepositoryInterface
{
    const DATE_FORMAT = 'd/m/Y H:i:s';

    /** @var string */
    private $csvPath;

    /**
     * CsvRecipeRepository constructor.
     * @param string $csvPath
     */
    public function __construct(string $csvPath)
    {
        $this->csvPath = $csvPath;
    }

    /**
     * {@inheritdoc}
     */
    public function find(int $id): ?Recipe
    {
        $recipes = $this->findBy(['id' => $id], 0, 1);
        if ($recipes) {
            return $recipes[0];
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function findBy(array $criteria = [], int $page = 0, int $pageSize = 10): array
    {
        $fp = fopen($this->csvPath, 'r');
        $recipes = [];

        $headers = fgetcsv($fp);
        if (!$headers) {
            fclose($fp);
            return $recipes;
        }

        // clean up criteria
        foreach ($criteria as $key => $value) {
            if (!in_array($key, $headers)) {
                unset($criteria[$key]);
            }
        }

        $skip = ($page) * $pageSize;

        $matchIndex = 0;
        while ($row = fgetcsv($fp)) {
            $rowWithHeaders = array_combine($headers, $row);

            // filtering
            $match = true;
            foreach ($criteria as $key => $value) {
                if ($rowWithHeaders[$key] != $value) {
                    $match = false;
                    break;
                }
            }
            if (!$match) {
                continue;
            }

            $matchIndex += 1;
            if ($matchIndex <= $skip) {
                continue;
            }

            $recipes[] = $this->createRecipeFromRow(array_values($rowWithHeaders));

            if (count($recipes) === $pageSize) {
                break;
            }
        }
        fclose($fp);

        return $recipes;
    }


    /**
     * {@inheritdoc}
     */
    public function save(Recipe $recipe)
    {
        $fpOriginal = fopen($this->csvPath, 'r');
        $tempfile = tempnam(dirname($this->csvPath), 'temp_');
        $fpNew = fopen($tempfile, 'w');

        // this will be slow on large dataset, good enough for small CSVs
        // should be migrated to proper storage backend
        $maxId = 0;
        $recipeSaved = false;
        while ($row = fgetcsv($fpOriginal)) {
            $maxId = max($maxId, (int) $row[0]);
            if ($row[0] == $recipe->getId()) {
                fputcsv($fpNew, $this->createRowFromRecipe($recipe));
                $recipeSaved = true;
            } else {
                fputcsv($fpNew, $row);
            }
        }

        if (!$recipeSaved) {
            $recipe->setId($maxId + 1);
            fputcsv($fpNew, $this->createRowFromRecipe($recipe));
        }

        fclose($fpOriginal);
        fclose($fpNew);
        unlink($this->csvPath);
        rename($tempfile, $this->csvPath);
    }

    private function createRecipeFromRow(array $row): Recipe
    {
        $recipe = new Recipe();

        $utc = new \DateTimeZone('UTC');
        $createdAt = \DateTimeImmutable::createFromFormat(static::DATE_FORMAT, $row[1], $utc);
        $updatedAt = \DateTimeImmutable::createFromFormat(static::DATE_FORMAT, $row[2], $utc);

        $recipe
            ->setId((int) $row[0])
            ->setCreatedAt($createdAt)
            ->setUpdatedAt($updatedAt)
            ->setBoxType($row[3])
            ->setTitle($row[4])
            ->setSlug($row[5])
            ->setShortTitle($row[6])
            ->setMarketingDescription($row[7])
            ->setCaloriesKcal((int) $row[8])
            ->setProteinGrams((int) $row[9])
            ->setFatGrams((int) $row[10])
            ->setCarbsGrams((int) $row[11])
            ->setBulletpoint1($row[12])
            ->setBulletpoint2($row[13])
            ->setBulletpoint3($row[14])
            ->setRecipeDietTypeId($row[15])
            ->setSeason($row[16])
            ->setBase($row[17])
            ->setProteinSource($row[18])
            ->setPreparationTimeMinutes((int) $row[19])
            ->setShelfLifeDays((int) $row[20])
            ->setEquipmentNeeded($row[21])
            ->setOriginCountry($row[22])
            ->setRecipeCuisine($row[23])
            ->setInYourBox(explode(',', $row[24]))
            ->setGoustoReference((int) $row[25]);

        return $recipe;
    }

    private function createRowFromRecipe(Recipe $recipe): array
    {
        return [
            $recipe->getId(),
            $recipe->getCreatedAt()->format(static::DATE_FORMAT),
            $recipe->getUpdatedAt()->format(static::DATE_FORMAT),
            $recipe->getBoxType(),
            $recipe->getTitle(),
            $recipe->getSlug(),
            $recipe->getShortTitle(),
            $recipe->getMarketingDescription(),
            $recipe->getCaloriesKcal(),
            $recipe->getProteinGrams(),
            $recipe->getFatGrams(),
            $recipe->getCarbsGrams(),
            $recipe->getBulletpoint1(),
            $recipe->getBulletpoint2(),
            $recipe->getBulletpoint3(),
            $recipe->getRecipeDietTypeId(),
            $recipe->getSeason(),
            $recipe->getBase(),
            $recipe->getProteinSource(),
            $recipe->getPreparationTimeMinutes(),
            $recipe->getShelfLifeDays(),
            $recipe->getEquipmentNeeded(),
            $recipe->getOriginCountry(),
            $recipe->getRecipeCuisine(),
            implode(',', $recipe->getInYourBox()),
            $recipe->getGoustoReference(),
        ];
    }
}
