<?php

namespace App\Model\Repository;

use App\Model\Recipe;

/**
 * CSV backed recipe storage layer implementation
 */
class CsvRecipeRepository implements RecipeRepositoryInterface
{
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


    private function createRecipeFromRow(array $row): Recipe
    {
        $recipe = new Recipe();
        $recipe
            ->setId((int) $row[0])
            ->setCreatedAt(new \DateTimeImmutable(strtotime($row[1])))
            ->setUpdatedAt(new \DateTimeImmutable(strtotime($row[2])))
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
}
